<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.invoke.aop.JoinPoint');

  /**
   * Weave interceptors into sourcecode
   *
   * @purpose  AOP
   */
  class Weaver extends Object {

    /**
     * Weave aspects
     *
     * @param   string class
     * @param   array<string, mixed> pc Pointcuts
     * @param   string bytes
     * @return  string woven code
     */
    public static function weaved($class, $pc, $bytes) {
      $tokens= token_get_all($bytes);
      $r= '';
      for ($i= 0, $s= sizeof($tokens); $i < $s; $i++) {
        if (T_FUNCTION !== $tokens[$i][0]) {
          $r.= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
          continue;
        }

        // Found a method
        $name= $tokens[$i+ 2][1];
        if (isset($pc[$name])) {
          $cut= $name;
        } else if (isset($pc['*'])) {
          $cut= '*';
        } else {
          $r.= $tokens[$i][1];
          continue;
        }
        
        // There is at least one pointcut for this method, weave it
        $brackets= 0;
        $i+= 3;
        $decl= ''; $args= array();
        do {
          if ('(' === $tokens[$i][0]) $brackets++;
          if (')' === $tokens[$i][0]) $brackets--;
          if (T_VARIABLE === $tokens[$i][0]) $args[]= $tokens[$i][1];
          $decl.= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
          $i++;
        } while ($brackets > 0);

        $r.= 'function '.$name.$decl.' { ';
        $inv= 'call_user_func(Aspects::$pointcuts[\''.$class.'\'][\''.$cut.'\']';
        $pass= '('.implode(', ', $args).')';
        if (isset($pc[$cut][AROUND])) {
          $r.= 'return '.$inv.'['.AROUND.'], new JoinPoint($this, \''.$name.'\', array'.$pass.')); }';
        } else {

          // @before
          isset($pc[$cut][BEFORE]) 
            ? $r.= $inv.'['.BEFORE.'], new JoinPoint($this, \''.$name.'\', array'.$pass.'));'
            : TRUE
          ;

          // @except
          isset($pc[$cut][THROWING])
            ? $r.= 'try { $r= $this->·'.$name.$pass.'; } catch (Exception $e) { '.$inv.'['.THROWING.'], new JoinPoint($this, \''.$name.'\', array'.$decl.'), $e); throw $e; } '
            : $r.= '$r= $this->·'.$name.$pass.';';
          ;

          // @after
          isset($pc[$cut][AFTER])
            ?  $r.= $inv.'['.AFTER.'], new JoinPoint($this, \''.$name.'\', array'.$pass.'), $r);'
            : TRUE
          ;

          $r.= ' return $r; }';
        }
        $r.= ' function ·'.$name.$decl.' ';
      }
      
      return $r;
    }
  }
?>
