<?php
/* stregReplace */

# thisfile
  $thisfile = basename(__FILE__, '.php');
 
# language
  i18n_merge($thisfile) || i18n_merge($thisfile, 'en_US');
 
# requires
  require_once(GSPLUGINPATH.$thisfile.'/class.php');
  
# class instantiation
  $stregreplace = new stregReplace; // instantiate class

# register plugin
  register_plugin(
    $stregreplace->info('id'),
    $stregreplace->info('name'),
    $stregreplace->info('version'),
    $stregreplace->info('author'),
    $stregreplace->info('url'),
    $stregreplace->info('description'),
    $stregreplace->info('page'),
    array($stregreplace, 'admin')
  );
  
# activate actions/filters
  # back-end
    add_action($stregreplace->info('page').'-sidebar', 'createSideMenu' , array($stregreplace->info('id'), $stregreplace->info('sidebar'))); // sidebar link
?>