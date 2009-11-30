
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
          (returncode, result, error)= self.xpidedoc(window, 'checksyntax', ["-ln", self.lint_map[tb.get_language().get_id()]])
          result= result.splitlines()
        except KeyError:
            dialog.TextCalltip(window).setText("Lint for " + window.get_active_document().get_language().get_name() + " does not exist").run()
        except AttributeError:
            dialog.TextCalltip(window).setText("Document has no specified language").run()

        if (0 != returncode):
            dialog.TextCalltip(window).setText(error).run()
            return

        if (0 == len(result[2])): return

        err_line= int(result.pop(0)) - 1
        err_col=  int(result.pop(0))
        insert_iter= tb.get_iter_at_line_index(err_line, err_col)
        tb.place_cursor(insert_iter)
        window.get_active_view().scroll_to_iter(insert_iter, 0.1, False)
        dialog.TextCalltip(window).setText("\n".join(result)).run()

    def openclass(self, action, window):
        (returncode, result, error)= self.xpidedoc(window, 'grepclassfile')
        if (0 == returncode):
            window.create_tab_from_uri(result, window.get_active_document().get_encoding(), 0, False, True)
        else:
            dialog.TextCalltip(window).setText(error).run()

    def complete(self, action, window):
        tb= window.get_active_document()
        (returncode, result, error)= self.xpidedoc(window, 'complete')
        if (0 != returncode):
            dialog.TextCalltip(window).setText(error).run()
            return

        result= result.splitlines()
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

    def toggleClass(self, action, window):
        tb= window.get_active_document()
        (returncode, result, error)= self.xpidedoc(window, 'toggleClass')
        if (0 != returncode):
            dialog.TextCalltip(window).setText(error).run()
            return

        result= result.splitlines()
        rep_pos= int(result.pop(0))
        rep_len= int(result.pop(0))
        rep_toggle= result.pop(0)

        tb.delete(
            tb.get_iter_at_offset(rep_pos),
            tb.get_iter_at_offset(rep_pos + rep_len)
        )
        tb.insert(tb.get_iter_at_offset(rep_pos), rep_toggle)

    def makeAccessors(self, action, window):
        (returncode, result, error)= self.xpidedoc(window, 'memberInfo')
        if (0 != returncode):
            dialog.TextCalltip(window).setText(error).run()
            return

        ma_dialog= dialog.MakeAccessor(window)
        for line in result.splitlines():
            (m_final, m_static, m_scope, m_name, m_type, ma_set, ma_get)= line.split(':')
            ma_dialog.addMember(m_name, m_type, not bool(int(ma_set)), not bool(int(ma_get)));
        ma_list= ma_dialog.run()
        if (ma_list is None): return

        confs= []
        for r in ma_list:
            (ma_name, ma_type, ma_set, ma_get, ma_xtype, ma_xedit, ma_dim, ma_dedit)= r
            accs= []
            if (ma_set): accs.append('set')
            if (ma_get): accs.append('get')
            dim= str(int(ma_dim.get_value()))
            confs.append(':'.join([ma_name, ma_type, ma_xtype, dim, '+'.join(accs)]))

        (returncode, result, error)= self.xpide(window, 'createAccessors', os.linesep.join(confs))
        window.get_active_document().insert_at_cursor(result)

    def activate(self, window):
        self._ui= XpIdeUi(self, window)

    def deactivate(self, window):
        self._ui.shutdown()

    def update_ui(self, window):
        pass

    def xpidedoc(self, window, command, args= []):
        tb= window.get_active_document()
        return self.xpide(window, command, tb.get_text(tb.get_start_iter(), tb.get_end_iter()), args)

    def xpide(self, window, command, text, args= []):
        tb= window.get_active_document()
        cursor= tb.get_iter_at_mark(tb.get_insert())
        proc= subprocess.Popen(
            [
                "xpide",
                "Gedit",
                command,
                "-se", "UTF-8",
                "-fc", os.path.dirname(tb.get_uri()),
                "-cp", str(cursor.get_offset()),
                "-cl", str(cursor.get_line()),
                "-cc", str(cursor.get_line_offset()),
            ] + args,
            stdin=subprocess.PIPE,
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE
        )
        (result, error)= proc.communicate(text)
        return (proc.returncode, result, error)

class XpIdeUi:
    def __init__(self, plugin, window):
        self._window= window
        self._plugin= plugin
        self._ui= self._window.get_ui_manager().add_ui_from_file(os.path.join(os.path.dirname(__file__), "xpide.ui"))
        self._ag= gtk.ActionGroup("XpIdePluginActions")

        self._window.get_ui_manager().insert_action_group(self._ag, -1);
        self._ag.add_action(gtk.Action("XpIde", "XP", None, None))
        
        action= gtk.Action("XpIdeComplete", "complete", None, None)
        self._ag.add_action_with_accel(action, "<Shift><Control>space")
        action.connect("activate", self._plugin.complete, self._window)

        action= gtk.Action("XpIdeToggleClass", "toggle class", None, None)
        self._ag.add_action_with_accel(action, "<Shift><Control>t")
        action.connect("activate", self._plugin.toggleClass, self._window)

        action= gtk.Action("XpIdeOpenClass", "open XP class", None, None)
        self._ag.add_action_with_accel(action, "<Shift><Control>o")
        action.connect("activate", self._plugin.openclass, self._window)

        action= gtk.Action("XpIdeLint", "lint", None, None)
        self._ag.add_action_with_accel(action, "<Alt>c")
        action.connect("activate", self._plugin.lint, self._window)

        action= gtk.Action("XpIdeMkAccessors", "make accessors", None, None)
        self._ag.add_action_with_accel(action, "<Shift><Alt>a")
        action.connect("activate", self._plugin.makeAccessors, self._window)

    def shutdown(self):
        self._window.get_ui_manager().remove_ui(self._ui)
        self._window.get_ui_manager().remove_action_group(self._ag)
        self._window.get_ui_manager().ensure_update()

