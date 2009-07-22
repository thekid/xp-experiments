
import gtk
import gobject
import subprocess
import gedit
import os

class XpIdeUi:
    def __init__(self, plugin, window):
        self._window= window
        self._plugin= plugin
        self._ui= self._window.get_ui_manager().add_ui_from_file(os.path.join(os.path.dirname(__file__), "xpide.ui"))
        self._ag= gtk.ActionGroup("XpIdePluginActions")

        self._window.get_ui_manager().insert_action_group(self._ag, -1);
        self._ag.add_action(gtk.Action("XpIde", "XP", None, None))
        
        completeAction= gtk.Action("XpIdeComplete", "complete", None, None)
        self._ag.add_action_with_accel(completeAction, "<Shift><Control>space")
        completeAction.connect("activate", self._plugin.complete, self._window)

    def shutdown(self):
        self._window.get_ui_manager().remove_ui(self._ui)
        self._window.get_ui_manager().remove_action_group(self._ag)
        self._window.get_ui_manager().ensure_update()

class XpIdePlugin(gedit.Plugin):
    def activate(self, window):
        self._ui= XpIdeUi(self, window)

    def deactivate(self, window):
        self._ui.shutdown()

    def update_ui(self, window):
        pass
        
    def complete(self, action, window):
        tb= window.get_active_document()
        cursor= tb.get_iter_at_mark(tb.get_insert())
        completion= subprocess.Popen(
            [
                "xpide",
                "xp.ide.completion.Runner",
                "xp.ide.completion.Gedit",
                "-p", str(cursor.get_offset()),
                "-l", str(cursor.get_line()),
                "-c", str(cursor.get_line_offset()),
            ],
            stdin=subprocess.PIPE,
            stdout=subprocess.PIPE
        )
        completion.stdin.write(tb.get_text(tb.get_start_iter(), tb.get_end_iter()))
        completion.stdin.close()
        
        rep_pos= int(completion.stdout.next())
        rep_len= int(completion.stdout.next())
        sug_cnt= int(completion.stdout.next())
        if (sug_cnt == 0): return
        if (sug_cnt == 1):
            suggestion= completion.stdout.next().strip()
        else:
            sug_dialog= TextSelectDialog(master= window, title="")
            for sug in completion.stdout: sug_dialog.addOption(sug.strip())
            suggestion= sug_dialog.run()
            if (suggestion is None): return
        tb.delete(
            tb.get_iter_at_offset(rep_pos),
            tb.get_iter_at_offset(rep_pos + rep_len)
        )
        tb.insert(tb.get_iter_at_offset(rep_pos), suggestion)

class TextSelectDialog(gtk.Dialog):
    def __init__(self, master=None, title=None):
        gtk.Dialog.__init__(self)
        if master: self.set_transient_for(master)
        if title:  self.set_title(title)
        self.set_modal(True)
        self.set_destroy_with_parent(True)
        self.set_has_separator(False)
        self.set_resizable(False)
        self.set_decorated(False)
        list_col= gtk.TreeViewColumn(None, gtk.CellRendererText(), text= 0)
        list_col.set_sort_order(gtk.SORT_ASCENDING)
        self.list= gtk.ListStore(gobject.TYPE_STRING)
        self.view= gtk.TreeView(self.list)
        self.view.set_headers_visible(False)
        self.view.append_column(list_col)
        self.view.connect("key-press-event", self.keypressEH)
        self.view.connect("button-press-event", self.buttonpressEH)
        self.view.show()
        self.vbox.pack_end(self.view)
    
    def addOption(self, text):
        self.list.set(self.list.append(), 0, text)
        
    def run(self):
        ret= gtk.Dialog.run(self)
        self.hide()
        if (ret != gtk.RESPONSE_OK): return None
        ret_iter= self.view.get_selection().get_selected()[1]
        if (ret_iter is None): return None
        return self.list.get(ret_iter, 0)[0]

    def keypressEH(self, widget, event):
        if (gtk.gdk.keyval_name(event.keyval) in ["Return", "space"]):
            self.response(gtk.RESPONSE_OK);
            return True
        return False

    def buttonpressEH(self, widget, event):
        if (gtk.gdk._2BUTTON_PRESS == event.type):
            self.response(gtk.RESPONSE_OK);
            return True
        return False
