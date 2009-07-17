
import gtk
import gedit

class XpIde:
    def __init__(self, plugin, window, menu):
        self._window= window
        self._plugin= plugin
        self._menu= menu
        menuBar= filter(lambda e:isinstance(e, gtk.MenuBar), reduce(lambda l,e:l + e.get_children(), filter(lambda e:isinstance(e, gtk.VBox), self._window.get_children()), []))[0]
        menus= menuBar.get_children()
        pos= menus[len(menus) - 1]
        menuBar.remove(pos)
        menuBar.add(self._menu)
        menuBar.add(pos)
        self._menu.show()

    def deactivate(self):
        self._window= None
        self._plugin= None
        self._menu.hide()

    def update_ui(self):
        pass

class XpIdePlugin(gedit.Plugin):
    def __init__(self):
        gedit.Plugin.__init__(self)
        self.instances= {}
        self.menu= gtk.MenuItem("XP")

    def activate(self, window):
        self.instances[window]= XpIde(self, window, self.menu)

    def deactivate(self, window):
        self.instances[window].deactivate()

    def update_ui(self, window):
        self.instances[window].update_ui()

