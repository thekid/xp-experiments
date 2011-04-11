<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  uses(
    'lang.types.String',
    'lang.types.Character',
    'io.streams.MemoryOutputStream',
    'text.StringTokenizer',
    'webservices.json.JsonException',
    'webservices.json.IJsonDecoder',
    'webservices.json.JsonParser',
    'webservices.json.JsonLexer'
  );

  // Defines for the tokenizer

  /**
   * JSON decoder and encoder
   *
   * @test      xp://net.xp_framework.unittest.json.JsonDecoderTest
   * @see       http://json.org
   * @purpose   JSON en- and decoder
   */
  class JsonDecoderT extends Object implements IJsonDecoder {
  
    /**
     * Encode PHP data into JSON
     *
     * @param var data
     * @return string
     * @throws webservices.json.JsonException
     */
    public function encode($data) {
      $stream= new MemoryOutputStream();
      $this->streamEncode($data, $stream);
      return $stream->getBytes();
    }

    /**
     * Encode PHP data into 
     *
     * @param   var data
     * @param   var stream
     * @return  string
     * @throws  webservices.json.JsonException if the data could not be serialized
     */
    public function streamEncode($data, $stream) {
      static $controlChars= array(
        '"'   => '\\"', 
        '\\'  => '\\\\', 
        '/'   => '\\/', 
        "\b"  => '\\b',
        "\f"  => '\\f', 
        "\n"  => '\\n', 
        "\r"  => '\\r', 
        "\t"  => '\\t'
      );
      switch (gettype($data)) {
        case 'string': {
          $stream->write('"'.strtr(utf8_encode($data), $controlChars).'"');
          return TRUE;
        }
        case 'integer': {
          $stream->write(strval($data));
          return TRUE;
        }
        case 'double': {
          $stream->write(strval($data));
          return TRUE;
        }
        case 'boolean': {
          $stream->write(($data ? 'true' : 'false'));
          return TRUE;
        }
        case 'NULL': {
          $stream->write('null');
          return TRUE;
        }
        
        case 'object': {
          // Convert objects to arrays and store the classname with them as
          // suggested by JSON-RPC
          if ($data instanceof Generic) {
            if (!method_exists($data, '__sleep')) {
              $vars= get_object_vars($data);
            } else {
              $vars= array(
                'constructor' => '__construct()'
              );
              foreach ($data->__sleep() as $var) $vars[$var]= $data->{$var};
            }
            
            // __xpclass__ is an addition to the spec, I added to be able to pass the FQCN
            $data= array_merge(
              array(
                '__jsonclass__' => array('__construct()'),
                '__xpclass__'   => utf8_encode($data->getClassName())
              ),
              $vars
            );
          } else {
            $data= (array)$data;
          }
          
          // Break missing intentially
        }
        
        case 'array': {
          if ($this->_isVector($data)) {
            // Bail out early on bordercase
            if (0 == sizeof($data)) {
              $stream->write('[ ]');
              return TRUE;
           };

            $stream->write('[ ');
            // Get first element
            $stream->write($this->encode(array_shift($data)));
            foreach ($data as $value) {
              $stream->write(' , '.$this->encode($value));
            }

            $stream->write(' ]');
            return TRUE;
          } else {
            $stream->write('{ ');

            $value= each($data);
            $stream->write($this->encode(
              (string)$value['key']).' : '.$this->encode($value['value']
            ));
            while ($value= each($data)) {
              $stream->write(
                ' , '.$this->encode((string)$value['key']).' : '.$this->encode($value['value'])
              );
            }

            $stream->write(' }');
            return TRUE;
          }
        }
        
        default: {
          throw new JsonException('Cannot encode data of type '.gettype($data));
        }
      }
    }
    
    /**
     * Decode a string into a PHP data structure
     *
     * @param   string string
     * @return  var
     */
    public function decode($string) {
      $parser= new JsonParser();

      try{
        $result= $parser->parse(new JsonLexer($string));
      } catch (ParseException $pe) {
        throw new JsonException($pe);
      }

      return $result;
    }
    
    /**
     * Checks whether an array is a numerically indexed array
     * (a vector) or a key/value hashmap.
     *
     * @param   array data
     * @return  bool
     */
    protected function _isVector($data) {
      $start= 0;
      foreach (array_keys($data) as $key) {
        if ($key !== $start++) return FALSE;
      }
      
      return TRUE;
    }
  } 
?>
