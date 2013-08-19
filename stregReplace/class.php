<?php

class stregReplace {
  /* constants */
  const ID = 'stregReplace';
  const FILE = 'stregReplace';
  const VERSION = '0.1';
  const AUTHOR = 'Lawrence Okoth-Odida';
  const URL = 'http://lokida.co.uk';
  const PAGE = 'plugins';
  
  /* properties */
  private $plugin = array();
  
  /* methods */
  # constructor
  public function __construct() {
    
  }
  
  # make directories
  private function makeDirs() {
    $return = array();
    $paths = array(self::FILE, self::FILE.'/backups/', self::FILE.'/logs/');
    foreach ($paths as $path)
    if (!file_exists(GSDATAOTHERPATH.$path)) {
      $return[$path] = mkdir(GSDATAOTHERPATH.$path, '0755');
    }
    return $return;
  }
  
  # info
  public function info($info) {
    if (empty($this->plugin)) {
      $this->plugin['id'] = self::ID;
      $this->plugin['name'] = i18n_r(self::FILE.'/PLUGIN_NAME');
      $this->plugin['version'] = self::VERSION;
      $this->plugin['author'] = self::AUTHOR;
      $this->plugin['url'] = self::URL;
      $this->plugin['description'] = i18n_r(self::FILE.'/PLUGIN_DESC');
      $this->plugin['page'] = self::PAGE;
      $this->plugin['sidebar'] = i18n_r(self::FILE.'/PLUGIN_SIDEBAR');
    }
    
    if (isset($this->plugin[$info])) return $this->plugin[$info];
    else return false;
  }
  
  # replace
  private function stregReplace($from, $to, $type='str_replace', $dir='data') {
    // set up
    $timestamp = time();
    $backup = GSDATAOTHERPATH.self::FILE.'/backups/'.$timestamp.'.zip';
    $return = $ret = $log = array();
    $dir = rtrim(GSDATAPATH.$dir, '/');
    $files = glob($dir.'/*.xml');
    
    // start zipping
    $zip = new ZipArchive();
    
    // no directory/no files
    if (empty($files)) {
      return array('status' => 'error', 'msg' => i18n_r(self::FILE.'/NO_DIRECTORY'));
    }
    // files exist - lets do some replacing
    else {
      if ($zip->open($backup, ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
          // back up the file
          $filename = explode('/', $file);
          $content = file_get_contents($file);
          $zip->addFromString(end($filename), $content);
          
          // replace
          $log[] = $replaced = call_user_func_array($type, array($from, $to, $content));
          $ret[] = file_put_contents($file, $replaced);
        }
        
        $zip->close();
        
        // logging
        $logfile  = '-- SETUP --'."\n";
        $logfile .= '  FROM: '.implode(', ', $from)."\n";
        $logfile .= '  TO: '.implode(', ', $to)."\n";
        $logfile .= '  TYPE: '.$type."\n";
        $logfile .= '  DIR: '.$dir."\n\n";
        $logfile .= '-- STATUSES --'."\n";
        
        foreach ($log as $k => $l) {
          $logfile .= '  '.$files[$k].' -> '.($ret[$k] !== FALSE ? 'SUCCESS' : 'FAIL')."\n";
        }
        
        file_put_contents(GSDATAOTHERPATH.self::FILE.'/logs/'.$timestamp.'.txt', $logfile);
      }
      
      if (!in_array(false, $ret)) {
        return array('status' => 'updated', 'msg' => i18n_r(self::FILE.'/REPLACE_SUCCESS'));
      }
      else return false;
    }
  }
  
  # admin
  public function admin() {
    $this->makeDirs();
    $msg = false;
    
    if (!empty($_POST['stregReplace']) && !empty($_POST['from'])) {
      $msg = $this->stregReplace($_POST['from'], $_POST['to'], $_POST['type'], $_POST['directory']);
    }
    
    // error message
    if ($msg) {
      ?>
      <script>
        $(document).ready(function() {
          $('div.bodycontent').before('<div class="' + <?php echo json_encode($msg['status']); ?> + '" style="display:block;">'+<?php echo json_encode($msg['msg']); ?>+'</div>');
        }); // ready
      </script>
      <?php
    }
    
    include(GSPLUGINPATH.self::FILE.'/admin.php');

  }
}

?>