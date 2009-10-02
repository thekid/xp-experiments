<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  $package="xp.ide.info";

  uses(
    'xp.ide.source.parser.ClassParser',
    'xp.ide.source.parser.ClassLexer',
    'io.streams.MemoryInputStream',
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
      $members= array();

    /**
     * get class info
     *
     * @param  xp.ide.source.Element e
     * @return xp.ide.source.Element[]
     */
    public function visit(xp·ide·source·Element $e) {
      switch ($e->getClassName()) {
        case 'xp.ide.source.element.ClassFile':        $this->visitClassFile($e); break;
        case 'xp.ide.source.element.Package':          $this->visitPackage($e); break;
        case 'xp.ide.source.element.BlockComment':     $this->visitBlockComment($e); break;
        case 'xp.ide.source.element.Uses':             $this->visitUses($e); break;
        case 'xp.ide.source.element.Classdef':         $this->visitClassdef($e); break;
        case 'xp.ide.source.element.Apidoc':           $this->visitApidoc($e); break;
        case 'xp.ide.source.element.ApidocDirective':  $this->visitApidocDirective($e); break;
        case 'xp.ide.source.element.Annotation':       $this->visitAnnotation($e); break;
        case 'xp.ide.source.element.Classmembergroup': $this->visitClassmembergroup($e); break;
        case 'xp.ide.source.element.Classmember':      $this->visitClassmember($e); break;
        case 'xp.ide.source.element.Array':            $this->visitArray($e); break;
        case 'xp.ide.source.element.Classmethod':      $this->visitMethod($e); break;
        case 'xp.ide.source.element.Classmethodparam': $this->visitMethodparam($e); break;
      }
      return $this->members;
    }

    private function visitMethodparam($e) {
    }

    private function visitMethod($e) {
    }

    private function visitArray($e) {
    }

    private function visitClassmember($e) {
    }

    private function visitClassmembergroup($e) {
      $this->members[]= $e;
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
    }

    private function visitUses($e) {
    }

    private function visitBlockComment($e) {
    }

    private function visitPackage($e) {
    }

    private function visitClassFile($e) {
      $this->members= array();
      if ($e->getClassdef()) {
        $e->getClassdef()->accept($this);
      }
    }
  }
?>
