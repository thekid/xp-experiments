
import gobject
import gtk
import os

class Calltip(gtk.Dialog):
    def __init__(self, master=None, title=None):
        gtk.Dialog.__init__(self)
        if master: self.set_transient_for(master)
        if title:  self.set_title(title)
        self.set_modal(True)
        self.set_destroy_with_parent(True)
        self.set_has_separator(False)
        self.set_resizable(False)
        self.set_decorated(False)
    
    def run(self):
        ret= gtk.Dialog.run(self)
        self.hide()
        return ret

class TextSelectCalltip(Calltip):
    def __init__(self, master=None, title=None):
        Calltip.__init__(self, master, title)
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
        ret= Calltip.run(self)
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

class TextCalltip():
    def __init__(self, master=None, title=None):
        self._builder= gtk.Builder()
        self._builder.add_from_file(os.path.join(os.path.dirname(__file__), "dialog", "TextCalltip.ui"))
        self._dialog= self._builder.get_object("TextCalltip")
        if master: self._dialog.set_transient_for(master)
        if title:  self._dialog.set_title(title)
        self._hint= self._builder.get_object("hint")

    def setText(self, text):
        self._hint.set_text(text)

    def run(self):
        self._dialog.show()
        self._dialog.run()
        self._dialog.hide()

    def keypressEH(self, widget, event):
        self.response(gtk.RESPONSE_OK);
        return True

    def buttonpressEH(self, widget, event):
        self.response(gtk.RESPONSE_OK);
        return True

