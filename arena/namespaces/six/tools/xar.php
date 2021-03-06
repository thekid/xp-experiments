<?php 
  // {{{ string scanpath(string[] path, string home)
  //     Scans a path file 
  function scanpath($paths, $home) {
    $inc= '';
    foreach ($paths as $path) {
      if (!($d= @opendir($path))) continue;
      while ($e= readdir($d)) {
        if ('.pth' !== substr($e, -4)) continue;

        foreach (file($path.DIRECTORY_SEPARATOR.$e) as $line) {
          if ('#' === $line{0}) {
            continue;
          } else if ('~' === $line{0}) {
            $base= $home; $line= substr($line, 1);
          } else if ('/' === $line{0} || (':' === $line{1} && '\\' === $line{2})) {
            $base= '';
          } else {
            $base= $path; 
          }

          $inc.= $base.DIRECTORY_SEPARATOR.strtr(trim($line), '/', DIRECTORY_SEPARATOR).PATH_SEPARATOR;
        }
      }
      closedir($d);
    }
    return $inc;
  }
  // }}}

  $home= getenv('HOME');
  set_include_path(
    scanpath(explode(PATH_SEPARATOR, ini_get('user_dir')), $home).
    scanpath(array('.'), $home).
    get_include_path()
  );

  if (!include('lang.base.php')) {
    trigger_error('[bootstrap] Cannot determine boot class path', E_USER_ERROR);
    exit(0x3d);
  }
  xp::sapi('cli');

  $cl= \lang\ClassLoader::registerLoader(new \lang\archive\ArchiveClassLoader($argv[1]));
  $pr= \util\Properties::fromString($cl->getResource('META-INF/manifest.ini'));
  exit(\lang\XPClass::forName($pr->readString('archive', 'main-class'), $cl)->getMethod('main')->invoke(NULL, array(array_slice($argv, 2)))); 
?>
