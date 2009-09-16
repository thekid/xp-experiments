
import gtk
import subprocess
import gedit
import os
import dialog

class XpIdePlugin(gedit.Plugin):
    lint_map= {
        'php':  'Php',
        'sh':   'Sh',
        'xml':  'Xml',
        'xslt': 'Xml',
        'js':   'Js'
    }

    def lint(self, action, window):
        result= []
        tb= window.get_active_document()
        try:
          result= subprocess.Popen(
              [
                  "xpide",
                  "Gedit",
                  "checksyntax",
                  "-se", "UTF-8",
                  "-ln", self.lint_map[tb.get_language().get_id()]
              ],
              stdin=subprocess.PIPE,
              stdout=subprocess.PIPE
          ).communicate(tb.get_text(tb.get_start_iter(), tb.get_end_iter()))[0].splitlines()
        except KeyError:
            dialog.TextCalltip(window).setText("Lint for " + window.get_active_document().get_language().get_id() + " does not exist").run()
        except AttributeError:
            dialog.TextCalltip(window).setText("Document has no specified language").run()

        if (0 == len(result)): return

        err_line= int(result.pop(0)) - 1
        err_col=  int(result.pop(0))
        insert_iter= tb.get_iter_at_line_index(err_line, err_col)
        tb.place_cursor(insert_iter)
        window.get_active_view().scroll_to_iter(insert_iter, 0.1, False)
        dialog.TextCalltip(window).setText("\n".join(result)).run()

    def openclass(self, action, window):
        tb= window.get_active_document()
        cursor= tb.get_iter_at_mark(tb.get_insert())
        textproc= subprocess.Popen(
            [
                "xpide",
                "Gedit",
                "grepclassfile",
                "-se", "UTF-8",
                "-cp", str(cursor.get_offset()),
                "-cl", str(cursor.get_line()),
                "-cc", str(cursor.get_line_offset()),
            ],
            stdin=subprocess.PIPE,
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE
        )
        (result, error)= textproc.communicate(tb.get_text(tb.get_start_iter(), tb.get_end_iter()))
        if (0 == textproc.returncode):
            window.create_tab_from_uri(result, tb.get_encoding(), 0, False, True)
        else:
            dialog.TextCalltip(window).setText(error).run()

    def complete(self, action, window):
        tb= window.get_active_document()
        cursor= tb.get_iter_at_mark(tb.get_insert())
        result= subprocess.Popen(
            [
                "xpide",
                "Gedit",
                "complete",
                "-se", "UTF-8",
                "-cp", str(cursor.get_offset()),
                "-cl", str(cursor.get_line()),
                "-cc", str(cursor.get_line_offset()),
            ],
            stdin=subprocess.PIPE,
            stdout=subprocess.PIPE
        ).communicate(tb.get_text(tb.get_start_iter(), tb.get_end_iter()))[0].splitlines()
        
        rep_pos= int(result.pop(0))
        rep_len= int(result.pop(0))
        sug_cnt= int(result.pop(0))
        if (sug_cnt == 0):
            dialog.TextCalltip(window).setText("no object found").run()
            return
        if (sug_cnt == 1):
            suggestion= result.pop().strip()
        else:
            sug_dialog= dialog.TextSelectCalltip(window)
            for sug in result: sug_dialog.addOption(sug.strip())
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

        completeAction= gtk.Action("XpIdeLint", "lint", None, None)
        self._ag.add_action_with_accel(completeAction, "<Alt>c")
        completeAction.connect("activate", self._plugin.lint, self._window)

    def shutdown(self):
        self._window.get_ui_manager().remove_ui(self._ui)
        self._window.get_ui_manager().remove_action_group(self._ag)
        self._window.get_ui_manager().ensure_update()

