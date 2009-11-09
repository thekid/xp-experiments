<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  $package="xp.ide.source";

  uses(
    'xp.ide.source.IElementVisitor',
    'io.streams.StringWriter'
  );

  /**
   * source tree generator visitor
   * base object
   *
   * @purpose  IDE
   */
  class xp·ide·source·Generator extends Object implements xp·ide·source·IElementVisitor {

    private
      $out= NULL,
      $indent= 0,
      $iSign= '  ';

    public function __construct(TextWriter $output) {
      $this->out= $output;
    }

    public function getOutput() {
      return $this->out;
    }

    public function setOutput(TextWriter $output) {
      $this->out= $output;
    }

    public function setIndent($indent) {
      $this->indent= $indent;
    }

    public function getIndent() {
      return $this->indent;
    }

    private function indention() {
      $this->out->write(str_repeat($this->iSign, $this->indent));
    }

    public function visit(xp·ide·source·Element $e) {
      switch ($e->getClassName()) {
        case 'xp.ide.source.element.ClassFile':        return $this->visitClassFile($e);
        case 'xp.ide.source.element.Package':          return $this->visitPackage($e);
        case 'xp.ide.source.element.BlockComment':     return $this->visitBlockComment($e);
        case 'xp.ide.source.element.Uses':             return $this->visitUses($e);
        case 'xp.ide.source.element.Classdef':         return $this->visitClassdef($e);
        case 'xp.ide.source.element.Apidoc':           return $this->visitApidoc($e);
        case 'xp.ide.source.element.ApidocDirective':  return $this->visitApidocDirective($e);
        case 'xp.ide.source.element.Annotation':       return $this->visitAnnotation($e);
        case 'xp.ide.source.element.Classmembergroup': return $this->visitClassmembergroup($e);
        case 'xp.ide.source.element.Classmember':      return $this->visitClassmember($e);
        case 'xp.ide.source.element.Array':            return $this->visitArray($e);
        case 'xp.ide.source.element.Classmethod':      return $this->visitMethod($e);
        case 'xp.ide.source.element.Classmethodparam': return $this->visitMethodparam($e);
      }
    }

    private function visitMethodparam($e) {
      if ($h= $e->getTypehint()) $this->out->write($h.' ');
      $this->out->write('$'.$e->getName());
      if ($i= $e->getInit()) {
        $this->out->write('= ');
        $this->generateRightInit($i);
      }
    }

    private function visitMethod($e) {
      if ($a= $e->getApidoc()) $this->generateApidoc($a);
      if ($a= $e->getAnnotations()) $this->generateAnnotations($a);
      $this->indention();
      if ($e->isFinal()) $this->out->write('final ');
      if ($e->isAbstract()) $this->out->write('abstract ');
      $this->generateScope($e->getScope());
      if ($e->isStatic()) $this->out->write(' static');
      $this->out->write(' function '.$e->getName().'(');
      if ($ps= $e->getParams()) {
        $i= 1; $m= sizeOf($ps);
        foreach ($ps as $p) {
          $p->accept($this);
          if ($i++ !== $m) $this->out->write(', ');
        }
      }
      $this->out->write(') {');
      if ($c= $e->getContent()) {
        $this->generateContent($c);
        $this->indention();
      }
      $this->out->write('}');
    }

    private function visitArray($e) {
      $this->out->write('array(');
      if ($vs= $e->getValues()) {
        $this->out->writeLine();
        $this->indent++;
        $i= 1; $m= sizeOf($vs);
        foreach ($vs as $k => $v) {
          $this->indention();
          $this->out->write($k.' => ');
          $this->generateRightInit($v);
          $this->out->writeLine($i++ !== $m ? ',' : '');
        }
        $this->indent--;
        $this->indention();
      }
      $this->out->write(')');
    }

    private function visitClassmember($e) {
      $this->out->write('$'.$e->getName());
      if ($i= $e->getInit()) {
        $this->out->write('= ');
        $this->generateRightInit($i);
      }
    }

    private function visitClassmembergroup($e) {
      if ($ms= $e->getMembers()) {
        $this->indention();
        if ($e->isFinal()) $this->out->write('final ');
        $this->generateScope($e->getScope());
        $this->out->writeLine($e->isStatic() ? ' static' : '');
        $this->indent++;
        $i= 1; $mm= sizeOf($ms);
        foreach ($ms as $m) {
          $this->indention();
          $m->accept($this);
          if ($i++ !== $mm) $this->out->writeLine(',');
          else $this->out->write(';');
        }
        $this->indent--;
      }
    }

    private function visitAnnotation($e) {
      $this->out->write('@'.$e->getName());
      $s= sizeOf($e->getParams());
      if (0 == $s) return;
      $this->out->write("(");
      $i= 1;
      foreach($e->getParams() as $k => $v) {
        if (!is_integer($k)) $this->out->write($k.'=');
        $this->out->write("'".$v."'");
        if ($i++ < $s) $this->out->write(',');
      }
      $this->out->write(")");
    }

    private function visitApidocDirective($e) {
      $this->indention();
      $this->out->write(' * ');
      $this->out->write($e->getText());
    }

    private function visitApidoc($e) {
      $this->indention();
      $this->out->writeLine('/**');
      for ($i= 0, $lines= explode(PHP_EOL, $e->getText()), $m= sizeOf($lines); $i < $m; $i++) {
        $this->indention();
        $this->out->write(' * ');
        $this->out->writeLine($lines[$i]);
      }
      if ($e->getDirectives()) foreach ($e->getDirectives() as $d) {
        $d->accept($this);
        $this->out->writeLine();
      }
      $this->indention();
      $this->out->write(' */');
    }

    private function visitClassdef($e) {
      if ($a= $e->getApidoc()) $this->generateApidoc($a);
      if ($a= $e->getAnnotations()) $this->generateAnnotations($a);
      $this->indention();
      if ($e->isFinal()) $this->out->write('final ');
      if ($e->isAbstract()) $this->out->write('abstract ');
      $this->out->write(sprintf('class %s extends %s ', $e->getName(), $e->getParent()));
      if ($e->getInterfaces()) {
        $this->out->write('implements ');
        $this->out->write(implode(', ', $e->getInterfaces()).' ');
      }
      $this->out->write('{');
      if ($c= $e->getContent()) {
        $this->generateContent($c);
      } else {
        if ($cs= $e->getConstants()) {
          $this->indent++;
          $this->out->writeLine('');
          $this->indention();
          $this->out->writeLine('const');
          $this->indent++;
          $i= 1; $m= sizeOf($cs);
          foreach ($cs as $n => $v) {
            $this->indention();
            $this->out->write(sprintf('%s= %s', $n, $v));
            $this->out->writeLine($i++ !== $m ? ',' : ';');
          }
          $this->indent -= 2;
        }
        if ($cg= $e->getMembergroups()) {
          $this->indent++;
          $this->out->writeLine('');
          foreach ($cg as $g) {
            $g->accept($this);
            $this->out->writeLine('');
          }
          $this->indent--;
        }
        if ($mes= $e->getMethods()) {
          $this->indent++;
          $this->out->writeLine('');
          $i= 1; $m= sizeOf($mes);
          foreach ($mes as $me) {
            $me->accept($this);
            $this->out->writeLine('');
            if ($i++ !== $m) $this->out->writeLine('');
          }
          $this->indent--;
        }
      }
      $this->out->write('}');
    }

    private function visitUses($e) {
      $this->indention();
      $this->out->writeLine('uses(');
      $this->indent++;
      for ($i= 0, $lines= $e->getClassnames(), $m= sizeOf($lines); $i < $m; $i++) {
        $this->indention();
        $this->out->write(sprintf("'%s'", $lines[$i]));
        if ($i !== $m - 1) $this->out->write(',');
        $this->out->writeLine('');
      }
      $this->indent--;
      $this->indention();
      $this->out->write(');');
    }

    private function visitBlockComment($e) {
      $this->indention();
      $this->out->write('/*');
      for ($i= 0, $lines= explode(PHP_EOL, $e->getText()), $m= sizeOf($lines); $i < $m; $i++) {
        if (0 !== $i) {
          $this->out->writeLine('');
          $this->indention();
        }
        $this->out->write($lines[$i]);
      }
      $this->indention();
      $this->out->write('*/');
    }

    private function visitPackage($e) {
      $this->indention();
      $this->out->write(sprintf("\$package= '%s';", $e->getName()));
    }

    private function visitClassFile($e) {
      $this->out->writeLine('<?php');
      if ($e->getHeader()) {
        $e->getHeader()->accept($this);
        $this->out->writeLine('');
      }
      $this->indent++;
      if ($e->getPackage()) {
        $e->getPackage()->accept($this);
        $this->out->writeLine('');
        $this->out->writeLine('');
      }
      if ($e->getUses()) {
        $e->getUses()->accept($this);
        $this->out->writeLine('');
      }
      if ($e->getClassdef()) {
        $e->getClassdef()->accept($this);
        $this->out->writeLine('');
      }
      $this->indent--;
      $this->out->write('?>');
    }

    private function generateContent($c) {
      $this->indent++;
      $this->out->writeLine('');
      foreach (explode(PHP_EOL, $c) as $line) {
        $this->indention();
        $this->out->writeLine($line);
      }
      $this->indent--;
    }

    private function generateAnnotations($as) {
      $this->indention();
      $this->out->write('#[');
      for ($i= 0, $as, $m= sizeOf($as); $i < $m; $i++) {
        $as[$i]->accept($this);
        if ($i < $m -1) $this->out->write(',');
      }
      $this->out->writeLine(']');
    }

    private function generateApidoc($a) {
      $a->accept($this);
      $this->out->writeLine();
    }

    private function generateScope($s) {
      switch ($s) {
        case xp·ide·source·Scope::$PRIVATE:
        $this->out->write('private');
        break;

        case xp·ide·source·Scope::$PROTECTED:
        $this->out->write('protected');
        break;

        default:
        $this->out->write('public');
        break;
      }
    }

    private function generateRightInit($i) {
      $i instanceof xp·ide·source·Element ? $i->accept($this) : $this->out->write($i);
    }
  }
?>
