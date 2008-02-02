<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.cmd.CommandLineArgument');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class CommandLineParser extends Object {
    protected
      $arguments  = array(),
      $unboundMap = array();
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($args= NULL) {
      if (is_array($args)) $this->parse($args);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function arguments() {
      return $this->arguments;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function parse(array $args) {
      for ($offset= 0; $offset < sizeof($args); $offset++) {
        $arg= $args[$offset];
        
        // Check long option --long
        if ('--' == substr($arg, 0, 2)) {
          $parts= explode('=', substr($arg, 2), 2);
          if (1 == sizeof($parts)) $parts[]= TRUE;
          $this->arguments[]= new CommandLineArgument($parts[0], NULL, $parts[1], sizeof($this->arguments));
          continue;
        }
        
        // Check short value
        if ('-' == $arg{0}) {
        
          // In case short names are being used, there is no option to know in
          // advance whether it's a boolean flag (which then is TRUE when set) or
          // the next argument is the value to this option.
          // Therefore a convention is to write boolean options in full uppercase
          // notation.
          $name= substr($arg, 1);
          if (strtoupper($name) == $name) {
            $this->arguments[]= new CommandLineArgument(NULL, $name, TRUE, sizeof($this->arguments));
            continue;
          }
        
          $value= (isset($args[$offset+ 1])
            ? $args[++$offset]
            : NULL
          );
          $this->arguments[]= new CommandLineArgument(NULL, $name, $value, sizeof($this->arguments));
          continue;
        }
        
        $this->arguments[]= new CommandLineArgument(NULL, NULL, $arg, sizeof($this->arguments));
      }
      
      $this->registerUnbounds();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function registerUnbounds() {
      foreach ($this->arguments as $index => $arg) {
        if (!$arg->isNamed()) $this->unboundMap[]= $index;
      }
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function slice($start, $end) {
      $slice= new self();
      $slice->arguments= array_slice($this->arguments, $start, $end);
      $slice->registerUnbounds();
      return $slice;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function numberOfArguments() {
      return sizeof($this->arguments);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function argument($long, $short= NULL, $default= NULL) {
      foreach ($this->arguments as $arg) {
        if ($arg->matches($long, $short)) return $arg;
      }
      
      if (NULL !== $default) return $default;
      $opt= ($long ? '--'.$long : '-'.$short);
      throw new IllegalArgumentException('No argument found for option '.$opt);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function exists($long, $short= NULL) {
      foreach ($this->arguments as $arg) {
        if ($arg->matches($long, $short)) return TRUE;
      }
      
      return FALSE;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function at($position, $default= NULL) {
      if (!isset($this->unboundMap[$position]) && NULL === $default)
        throw new IllegalArgumentException('No argument for position '.$position.' (got '.sizeof($this->unboundMap).')');

      return (isset($this->unboundMap[$position])
        ? $this->arguments[$this->unboundMap[$position]]
        : $default
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function existsAt($position) {
      return isset($this->unboundMap[$position]);
    }
  }
?>
