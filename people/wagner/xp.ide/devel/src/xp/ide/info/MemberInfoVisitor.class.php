<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  $package="xp.ide.info";

  uses(
    'xp.ide.source.parser.ClassParser',
    'xp.ide.source.parser.ClassLexer',
    'io.streams.StringWriter',
    'xp.ide.source.IElementVisitor'
  );

  /**
   * source tree generator visitor
   * base object
   *
   * @purpose  IDE
   */
  class xp·ide·info·MemberInfoVisitor extends Object implements xp·ide·source·IElementVisitor {

    private
      $output_stream= NULL,
      $out= NULL;

    public function __construct(OutputStream $output_stream) {
      $this->output_stream= $output_stream;
      $this->out= new StringWriter($this->output_stream);
    }

    public function getOutputStream() {
      return $this->output_stream;
    }

    public function setOutputStream(OutputStream $output_stream) {
      $this->output_stream= $output_stream;
      $this->out= new StringWriter($this->output_stream);
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
    }

    private function visitMethod($e) {
    }

    private function visitArray($e) {
    }

    private function visitClassmember($e) {
      var_dump($e);
    }

    private function visitClassmembergroup($e) {
      var_dump($e);
    }

    private function visitAnnotation($e) {
    }

    private function visitApidocDirective($e) {
    }

    private function visitApidoc($e) {
    }

    private function visitClassdef($e) {
      if ($c= $e->getContent()) {
        $cp= new xp·ide·source·parser·ClassParser();
        $cp->setTopElement($e);
        try {
          $cp->parse(new xp·ide·source·parser·ClassLexer(new MemoryInputStream($c)));
        } catch (ParseException $pe) {
        }
        $e->setContent(NULL);
      }

      if ($cg= $e->getMembergroups()) {
        foreach ($cg as $g) {
          $g->accept($this);
        }
      }
      if ($mes= $e->getMethods()) {
        foreach ($mes as $me) {
          $me->accept($this);
        }
      }
    }

    private function visitUses($e) {
    }

    private function visitBlockComment($e) {
    }

    private function visitPackage($e) {
    }

    private function visitClassFile($e) {
      if ($e->getClassdef()) {
        $e->getClassdef()->accept($this);
      }
    }
  }
?>
