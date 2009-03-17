<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('Comparable');

  class Read extends Object {

    private static function dumpOps($ops, $indent= '  ') {
      foreach (oel_export_op_array($ops) as $opline) {
        switch ($opline->opcode->mne) {
          case 'FETCH_CLASS': $details= array($opline->op2->value); break;
          case 'DECLARE_CLASS': $details= array($opline->op2->value); break;
          case 'DECLARE_INHERITED_CLASS': $details= array($opline->op2->value); break;
          case 'INIT_STATIC_METHOD_CALL': $details= array($opline->op2->value); break;
          case 'INIT_METHOD_CALL': $details= array($opline->op2->value); break;
          case 'INIT_FCALL_BY_NAME': $details= array($opline->op2->value); break;
          case 'SEND_VAL': $details= array($opline->extended_value, $opline->op1->value); break;
          case 'FETCH_OBJ_R': $details= array($opline->op2->value); break;
          case 'FETCH_DIM_R': $details= array($opline->op2->value); break;
          default: $details= NULL; // var_dump($opline);
        }
        Console::writeLinef(
          '%s@%-3d: <%03d> %s %s', 
          $indent,
          $opline->lineno,
          $opline->opcode->op,
          $opline->opcode->mne,
          $details ? '['.str_replace("\n", "\n".$indent, implode(', ', array_map(array('xp', 'stringOf'), $details))).']' : ''
        );
      }
    }
    
    public static function main(array $args) {
      if (!file_exists($args[0])) {
        throw new IllegalArgumentException('*** File "'.$args[0].'" does not exist!');
      }

      $fd= fopen($args[0], 'rb');
      $v= oel_read_header($fd);
      Console::writeLine('===> OEL version= ', $v);

      $ops= oel_read_op_array($fd);
      Console::writeLine('---> Op array= {');
      self::dumpOps($ops);
      Console::writeLine('}');
      fclose($fd);

      Console::writeLine('---> Executing...');
      $r= oel_execute($ops);

      Console::writeLine('===> Done, returns ', xp::stringOf($r));
      
      if (isset($args[1])) {
        Console::writeLine('---> ', $args[1], '= {');
        $method= explode('::', $args[1]);
        self::dumpOps($method);
        Console::writeLine('}');
      }
    }
  }
?>
