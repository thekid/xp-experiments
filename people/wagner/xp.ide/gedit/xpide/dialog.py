
import gobject
import gtk
import os

class Calltip():
    def __init__(self, dialog, master=None, title=None):
        self._builder= gtk.Builder()
        self._builder.add_from_file(os.path.join(os.path.dirname(__file__), "dialog", dialog + ".ui"))
        self._dialog= self._builder.get_object(dialog)
        self._dialog= self._builder.get_object(dialog)
        if master: self._dialog.set_transient_for(master)
        if title:  self._dialog.set_title(title)

    def run(self):
        self._dialog.show_all()
        ret= self._dialog.run()
        self._dialog.hide()
        return ret

class TextSelectCalltip(Calltip):
    def __init__(self, master=None, title=None):
        Calltip.__init__(self, "TextSelectCalltip", master, title)

        list_col= gtk.TreeViewColumn(None, gtk.CellRendererText(), text= 0)
        list_col.set_sort_order(gtk.SORT_ASCENDING)
        self._list= gtk.ListStore(gobject.TYPE_STRING)
        self._view= self._builder.get_object("suggestions")
        self._view.set_model(self._list)
        self._view.append_column(list_col)
        self._view.connect("key-press-event", self.keypressEH)
        self._view.connect("button-press-event", self.buttonpressEH)
    
    def addOption(self, text):
        self._list.set(self._list.append(), 0, text)
        return self
        
    def run(self):
        ret= Calltip.run(self)
        if (ret != gtk.RESPONSE_OK): return None
        ret_iter= self._view.get_selection().get_selected()[1]
        if (ret_iter is None): return None
        return self._list.get(ret_iter, 0)[0]

    def keypressEH(self, widget, event):
        if (gtk.gdk.keyval_name(event.keyval) in ["Return", "space"]):
            self._dialog.response(gtk.RESPONSE_OK);
            return True
        return False

    def buttonpressEH(self, widget, event):
        if (gtk.gdk._2BUTTON_PRESS == event.type):
            self._dialog.response(gtk.RESPONSE_OK);
            return True
        return False

class TextCalltip(Calltip):
    def __init__(self, master=None, title=None):
        Calltip.__init__(self, "TextCalltip", master, title)
        self._hint= self._builder.get_object("hint")

    def setText(self, text):
        self._hint.set_text(text)
        return self
