<?php
  uses(
    'org.gnome.glade.GladeSource',
    'org.gnome.gtk.Window',
    'lang.Process',
    'io.File',
    'lang.archive.Archive',
    'lang.types.String',
    'text.StreamTokenizer',
    'io.collections.FileCollection',
    'io.collections.ArchiveCollection',
    'io.collections.iterate.FilteredIOCollectionIterator',
    'io.collections.iterate.CollectionFilter',
    'io.collections.iterate.NameEqualsFilter',
    'io.collections.iterate.ExtensionEqualsFilter',
    'Project'
  );
  
  class Ide extends Object {
    protected $pixbufs= array();
    protected $server= NULL;

    public function loadProjects($base) {
      $this->projects->clear();
      $collection= new FileCollection($base);
      $filter= new NameEqualsFilter('VERSION');
      foreach (new FilteredIOCollectionIterator($collection, $filter, TRUE) as $e) {
        $origin= $e->getOrigin();
        $this->projects->append(
          NULL, 
          array($this->pixbuf('project'), substr($origin->getURI(), strlen($collection->getURI()), -1), 
          new Project($origin))
        );
      }
    }
    
    public function editorCommand() {
      $args= func_get_args();
      $client= new Process('nedit-nc', array_merge(array('-svrname '.__CLASS__), $args));
      $client->close();
    }
    
    public function onComplete($entry, $base) {
      $this->loadProjects($base.DIRECTORY_SEPARATOR.$entry->getText());
    }
    
    protected function addResources(GtkTreeModel $model, GtkTreeIter $it, $base) {
      foreach (new IOCollectionIterator($base) as $item) {
        if (strstr($item->getURI(), '.svn')) continue;                      // FIXME: Filter
        $icon= $item instanceof IOCollection ? 'resources' : 'resource';   // FIXME: Depending on MIME
        $model->append($it, array($this->pixbuf($icon), substr($item->getURI(), strlen($base->getURI())), $item));
      }
    }
    
    public function onSelectionChanged($selection) {
      list($model, $it)= $selection->get_selected();
      $value= $model->get_value($it, 2);

      if ($value instanceof Project && !$model->iter_has_child($it)) {

        // Scan for classes from all .pth files
        $classes= $model->append($it, array($this->pixbuf('classes'), 'Classes', NULL));
        foreach (new FilteredIOCollectionIterator($value->base, new ExtensionEqualsFilter('.pth')) as $pth) {
          foreach (new StreamTokenizer($pth->getInputStream(), "\r\n") as $path) {
            $q= new String($value->base->getURI().$path);
            if ($q->endsWith('.xar')) {
              $collection= new ArchiveCollection(new Archive(new File($q)));
              $p= $model->append($classes, array($this->pixbuf('xar'), 'Library '.basename($path), NULL));
            } else {
              $collection= new FileCollection($q);
              $p= $model->append($classes, array($this->pixbuf('folder'), 'Source Package '.basename($path), NULL));
            }
            $packages= array();
            foreach (new FilteredIOCollectionIterator($collection, new ExtensionEqualsFilter(xp::CLASS_FILE_EXT), TRUE) as $class) {
              $qname= strtr(substr($class->getURI(), strlen($collection->getURI()), -strlen(xp::CLASS_FILE_EXT)), '\\/', '..');
              $package= substr($qname, 0, strrpos($qname, '.'));
              if (!isset($packages[$package])) {
                $packages[$package]= $model->append($p, array($this->pixbuf('package'), $package, NULL));
              }
              
              $model->append($packages[$package], array($this->pixbuf('class'), $qname, $class));
            }
          }
        }
        
        // Scan for resources
        $this->addResources($model, $model->append($it, array($this->pixbuf('resources'), 'Resources', NULL)), $value->base);
      } else if ($value instanceof IOCollection && !$model->iter_has_child($it)) {
        $this->addResources($model, $it, $value);
      } else if ($value instanceof IOElement) {
        $uri= strtr($value->getURI(), DIRECTORY_SEPARATOR, "/");
        if (":" == $uri{1} && "/" == $uri{2}) {
          $uri= "/cygdrive/".$uri{0}.substr($uri, 2);
        }
        $this->editorCommand('"'.$uri.'"');
      }
    }
    
    public function pixbuf($name) {
      if (!isset($this->pixbufs[$name])) {
        $this->pixbufs[$name]= GdkPixbuf::new_from_file($this
          ->getClass()
          ->getPackage()
          ->getResourceAsStream($name.'.png')
          ->getURI()
        );
      }
      return $this->pixbufs[$name];
    }

    public function run($args) {
      $package= $this->getClass()->getPackage();
      
      $p= GladeSource::parse($package->getResource('ide.glade'));
      $w= cast($p->getWidget('main'), 'org.gnome.gtk.Window');
      $w->showAll();
      
      $this->server= new Process('nedit', array('-server', '-svrname '.__CLASS__));
      
      with ($container= $p->getWidget('treeview')); {
        $this->projects= new GtkTreeStore(
          GdkPixbuf::gtype,
          GObject::TYPE_STRING, 
          GObject::TYPE_PHP_VALUE
        ); 
        $container->setModel($this->projects);
        
        $column = new GtkTreeViewColumn();
        $pix= new GtkCellRendererPixbuf();
        $column->pack_start($pix, FALSE);
        $column->set_attributes($pix, 'pixbuf', 0);
        
        $txt= new GtkCellRendererText();
        $column->pack_start($txt, TRUE);
        $column->set_attributes($txt, 'text', 1);

        $container->handle->append_column($column);
        $container->getSelection()->connect('changed', array($this, 'onSelectionChanged'));
      }
      
      with ($input= $p->getWidget('complete')); {
        $completion= new GtkentryCompletion();
        $completion->set_model($this->projects);
        $completion->set_text_column(1);
        $input->handle->set_completion($completion);
      }
      
      $this->loadProjects($args[0]);

      // Closing a window doesn't stop the application!
      $w->connect(newinstance(Window::DeleteEvent, array($this), '{
        public function __construct($main) {
          $this->main= $main;
        }
        public function onDelete($source, $event) {
          Gtk::main_quit();
          $this->main->editorCommand("-do \'exit()\'");
          $this->main->server->close();
        }
      }'));
      Gtk::main();
    }
    
    public static function main(array $args) {
      create(new self())->run($args);
    }
  }
?>
