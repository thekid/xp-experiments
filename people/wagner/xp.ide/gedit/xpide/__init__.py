
import gtk
import subprocess
import gedit
import os
import dialog

class XpIdePlugin(gedit.Plugin):
    def openclass(self, action, window):
        tb= window.get_active_document()
        cursor= tb.get_iter_at_mark(tb.get_insert())
        result= textproc= subprocess.Popen(
            [
                "xpide",
                "xp.ide.text.Runner",
                "Gedit",
                "-a", "grepclassfile",
                "-p", str(cursor.get_offset()),
                "-l", str(cursor.get_line()),
                "-c", str(cursor.get_line_offset()),
            ],
            stdin=subprocess.PIPE,
            stdout=subprocess.PIPE
        ).communicate(tb.get_text(tb.get_start_iter(), tb.get_end_iter()))
        if (0 == textproc.returncode):
            window.create_tab_from_uri("file://" + result[0], tb.get_encoding(), 0, False, True)
        elif (1 == textproc.returncode):
            dialog.TextCalltip(master=window).setText(result[0]).run()
        else:
            dialog.TextCalltip(master=window).setText("class not found").run()

    def complete(self, action, window):
        tb= window.get_active_document()
        cursor= tb.get_iter_at_mark(tb.get_insert())
        completion= subprocess.Popen(
            [
                "xpide",
                "xp.ide.completion.Runner",
                "Gedit",
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
        if (sug_cnt == 0):
            dialog.TextCalltip(master=window).setText("no object found").run()
            return
        if (sug_cnt == 1):
            suggestion= completion.stdout.next().strip()
        else:
            sug_dialog= dialog.TextSelectCalltip(master= window)
            for sug in completion.stdout: sug_dialog.addOption(sug.strip())
            suggestion= sug_dialog.run()
            if (suggestion is None): return
        tb.delete(
            tb.get_iter_at_offset(rep_pos),
            tb.get_iter_at_offset(rep_pos + rep_len)
        )
        tb.insert(tb.get_iter_at_offset(rep_pos), suggestion)

    def activate(self, window):
        self._ui= XpIdeUi(self, window)

    def deactivate(self, window):
        self._ui.shutdown()

    def update_ui(self, window):
        pass
        
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

        completeAction= gtk.Action("XpIdeOpenClass", "open XP class", None, None)
        self._ag.add_action_with_accel(completeAction, "<Shift><Control>o")
        completeAction.connect("activate", self._plugin.openclass, self._window)

    def shutdown(self):
        self._window.get_ui_manager().remove_ui(self._ui)
        self._window.get_ui_manager().remove_action_group(self._ag)
        self._window.get_ui_manager().ensure_update()

