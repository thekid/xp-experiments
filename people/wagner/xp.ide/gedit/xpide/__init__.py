
import gtk
import os
import gedit

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
        window.get_active_document().insert_at_cursor("PENG")
        insert_mark= window.get_active_document().get_insert()
        cursor= window.get_active_document().get_iter_at_mark(insert_mark)
        print (
            "xpide xp.ide.completion.Runner xp.ide.completion.Nedit"
            " -p " + str(cursor.get_offset()) +
            " -l " + str(cursor.get_line()) +
            " -c " + str(cursor.get_line_offset())
        )
