
import gedit

class XpIde:
    def __init__(self, plugin, window):
        self._window= window
        self._plugin= plugin

    def deactivate(self):
        self._window= None
        self._plugin= None

    def update_ui(self):
        pass

class XpIdePlugin(gedit.Plugin):
    def __init__(self):
        gedit.Plugin.__init__(self)
        self.instances= {}

    def activate(self, window):
        self.instances[window]= XpIde(self, window)

    def deactivate(self, window):
        self.instances[window].deactivate()

    def update_ui(self, window):
        self.instances[window].update_ui()

