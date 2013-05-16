<?php
  uses(
    'org.gnome.glade.GladeSource',
    'org.gnome.gtk.Window',
    'org.gnome.gtk.Button',
    'lang.Process',
    'io.File',
    'util.MimeType',
    'util.collections.HashTable',
    'lang.archive.Archive',
    'lang.types.String',
    'lang.types.Integer',
    'text.StreamTokenizer',
    'io.streams.Streams',
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
    protected $files= NULL;

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
              $sep= strrpos($qname, '.');
              $package= substr($qname, 0, $sep);
              if (!isset($packages[$package])) {
                $packages[$package]= $model->append($p, array($this->pixbuf('package'), $package, NULL));
              }
              
              // Determine type. FIXME: Use doclet or something...
              $type= 'class';
              $st= new StreamTokenizer($class->getInputStream(), ' ');
              while ($st->hasMoreTokens()) {
                $t= $st->nextToken();
                switch ($t) {
                  case 'interface': $type= 'interface'; break 2;
                  case 'extends': switch ($st->nextToken()) {
                    case 'TestCase': $type= 'test'; break 2;
                    case 'Enum': $type= 'enum'; break 2;
                    case 'Command': $type= 'cli'; break 2;
                  }
                  break 2;
                }
              }
              
              $model->append($packages[$package], array($this->pixbuf($type), substr($qname, $sep+ 1), $class));
            }
          }
        }
        
        // Scan for resources
        $this->addResources($model, $model->append($it, array($this->pixbuf('resources'), 'Resources', NULL)), $value->base);
      } else if ($value instanceof IOCollection && !$model->iter_has_child($it)) {
        $this->addResources($model, $it, $value);
      } else if ($value instanceof IOElement) {
        if (!$this->files->containsKey($value)) {
          // FIXME: Move to own class {{{
          $src= new GtkSourceLanguagesManager();
          $lang= $src->get_language_from_mime_type('text/x-xp-source');    // FIXME: Figure out by actual mime
          var_dump($lang->get_style_scheme()->get_style_names());
          
          $buffer= new GtkSourceBuffer();
          $buffer->set_language($lang);
          $buffer->set_highlight(TRUE);
          $buffer->begin_not_undoable_action();  
          $buffer->set_text(Streams::readAll($value->getInputStream()));
          $buffer->end_not_undoable_action(); 
          
          $source= new GtkSourceView();
          $source->set_buffer($buffer);
          $source->set_show_line_numbers(TRUE);
          $source->set_show_line_markers(TRUE);
          $source->modify_font(new PangoFontDescription('Courier New 9'));

          // FIXME: Cache this
          $editor= GladeSource::parse($this->getClass()->getPackage()->getResource('source-editor.glade'));

          $editor->getWidget('container')->handle->add($source);

          $layout= new GtkVBox();   // FIXME: Element is here only for reparent()ing purpose
          $main= $editor->getWidget('main')->handle;
          $main->reparent($layout);
          $layout->show_all();
          // }}}
          
          /*
          $scintilla= new GtkScintilla();
          $scintilla->set_styling(-1, 'PHP');
          $scintilla->insert_text(-1, Streams::readAll($value->getInputStream()));

          // FIXME: Cache this
          $editor= GladeSource::parse($this->getClass()->getPackage()->getResource('source-editor.glade'));

          $editor->getWidget('container')->handle->add($scintilla);

          $layout= new GtkVBox();   // FIXME: Element is here only for reparent()ing purpose
          $main= $editor->getWidget('main')->handle;
          $main->reparent($layout);
          $layout->show_all();
          */
          
          // [ Label [x] ]
          $tab= new GtkHBox();
          $tab->pack_start(GtkImage::new_from_pixbuf($model->get_value($it, 0)));
          $tab->pack_start(new GtkLabel($model->get_value($it, 1)));
          $button= new Button();
          $button->handle->set_image(GtkImage::new_from_pixbuf($this->pixbuf('close')));
          $button->handle->set_relief(Gtk::RELIEF_NONE);
          $button->handle->set_size_request(18, 18);
                    
          $tab->pack_start($button->handle, FALSE);
          $tab->show_all();
          
          $id= $this->tabs->handle->append_page(
            $layout, 
            $tab
          );

          $button->connect(newinstance(Button::Clicked, array($this, $value), '{
            public function __construct($main, $value) {
              $this->main= $main;
              $this->value= $value;
            }
            public function onClicked($source) {
              $this->main->tabs->handle->remove_page($this->main->files[$this->value]->intValue());
              $this->main->files->remove($this->value);
            }
          }'));       

          $this->files->put($value, new Integer($id));
        }
        $this->tabs->setCurrentPage($this->files[$value]->intValue());
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
      $this->files= new HashTable();
      $p= GladeSource::parse($package->getResource('ide.glade'));
      $w= cast($p->getWidget('main'), 'org.gnome.gtk.Window');
      
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

      $this->tabs= $p->getWidget('tabs');
      $w->showAll();
      
      $this->loadProjects($args[0]);

      // Closing a window doesn't stop the application!
      $w->connect(newinstance(Window::DeleteEvent, array($this), '{
        public function __construct($main) {
          $this->main= $main;
        }
        public function onDelete($source, $event) {
          Gtk::main_quit();
        }
      }'));
      Gtk::main();
    }
    
    public static function main(array $args) {
      create(new self())->run($args);
    }
  }
?>
