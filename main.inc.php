<?php
/*
Version: 1.0
Plugin Name: Simple Copyright
Plugin URI: // Here comes a link to the Piwigo extension gallery, after
           // publication of your plugin. For auto-updates of the plugin.
Author: Geekitude
Description: Affichage d'un copyright de base en respectant le champs IPTC correspondant s'il existe.
*/

// Check whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
global $conf;
var_dump($conf['SimpleCopyright']);

// Define the path to our plugin.
define('SIMPLECR_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
//define('SIMPLECR_ABS_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
//define('SKELETON_ID',      basename(dirname(__FILE__)));
//define('SKELETON_PATH' ,   PHPWG_PLUGINS_PATH . SKELETON_ID . '/');

// Hook on to an event to show the administration page.
add_event_handler('get_admin_plugin_menu_links', 'simplecr_admin_menu');
//add_event_handler('init', 'simplecr_init');

// Add an entry to the 'Plugins' menu.
function simplecr_admin_menu($menu) {
 array_push(
   $menu,
   array(
     'NAME'  => 'Simple Copyright',
     'URL'   => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin.php'
   )
 );
 return $menu;
}


/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
//function simplecr_init()
//{
//  global $conf, $simplecr, $select_options;

  // load plugin language file
////  load_language('plugin.lang', SKELETON_PATH);

  // prepare plugin configuration
////  $simplecr = safe_unserialize($conf['SimpleCopyright']);
////  $select_options = array(
////      'by-nc-nd'
////  )
////var_dump($simplecr);
////var_dump($simplecr['select']);
//}

?>
