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
//var_dump($conf['SimpleCopyright']);

// Define the path to our plugin.
define('SIMPLECR_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
//define('SIMPLECR_ABS_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');
//define('SKELETON_ID',      basename(dirname(__FILE__)));
//define('SKELETON_PATH' ,   PHPWG_PLUGINS_PATH . SKELETON_ID . '/');

// Hook on to an event to show the administration page.
add_event_handler('get_admin_plugin_menu_links', 'simplecr_admin_menu');
add_event_handler('init', 'simplecr_init');
add_event_handler('loc_end_page_tail', 'simplecr_footer');

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
function simplecr_init()
{
//  global $conf, $simplecr, $select_options;
//  global $conf, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr;
  global $conf, $simplecr, $simplecr_label, $simplecr_url;

  // load plugin language file
//  load_language('plugin.lang', SIMPLECR_PATH);

  // prepare plugin configuration
  $simplecr = safe_unserialize($conf['SimpleCopyright']);
  //var_dump($simplecr['select']);
    if ($simplecr['select'] == "by") {
        $simplecr_label = "Attribution 4.0 International (CC BY 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by/4.0/";
//        $simplecr_descr = "You are free to: share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.";
    } elseif ($simplecr['select'] == "by-sa") {
        $simplecr_label = "Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-sa/4.0/";
//        $simplecr_descr = "You are free to: share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
    } elseif ($simplecr['select'] == "by-nd") {
        $simplecr_label = "Attribution-NoDerivatives 4.0 International (CC BY-ND 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nd/4.0/";
//        $simplecr_descr = "You are free to: share (copy and redistribute the material in any medium or format) for any purpose, even commercially. If you remix, transform, or build upon the material, you may not distribute the modified material.";
    } elseif ($simplecr['select'] == "by-nc") {
        $simplecr_label = "Attribution-NonCommercial 4.0 International (CC BY-NC 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nc/4.0/";
//        $simplecr_descr = "You are free to: share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit.";
    } elseif ($simplecr['select'] == "by-nc-sa") {
        $simplecr_label = "Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nc-sa/4.0/";
//        $simplecr_descr = "You are free to: share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
    } elseif ($simplecr['select'] == "by-nc-nd") {
        $simplecr_label = "Attribution-NonCommercial-NoDerivatives 4.0 International (CC BY-NC-ND 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nc-nd/4.0/";
//        $simplecr_descr = "You are free to: share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.";
    } elseif ($simplecr['select'] == "custom") {
        $simplecr_label = $simplecr['customlabel'];
        $simplecr_url = $simplecr['customurl'];
//        $simplecr_descr = $simplecr['customdescr'];
    }
////  $select_options = array(
////      'by-nc-nd'
////  )
////var_dump($simplecr);
////var_dump($simplecr['select']);
}

function simplecr_footer()
 {
//	global $page, $template, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr;
	global $page, $template, $simplecr, $simplecr_label, $simplecr_url;
   if (($simplecr['enablefootercr'] == 1) and (script_basename() != 'admin') and ($page['body_id'] != 'thePopuphelpPage'))
  {
  // load plugin language file
  load_language('plugin.lang', SIMPLECR_PATH);
//$PAED = pwg_db_fetch_assoc(pwg_query("SELECT state FROM " . PLUGINS_TABLE . " WHERE id = 'ExtendedDescription';"));
//if($PAED['state'] == 'active') add_event_handler('AP_render_content', 'get_user_language_desc');

//var_dump($lang);
//$pat=trigger_change('AP_render_content', $conf['persoFooter']);
//var_dump($simplecr_url);
$copyright_link = '<a href='.$simplecr_url.' title="See licence">'.$simplecr_label.'</a>';
//$copyright_string .= '<div id="helpContent"><fieldset><legend>{\'Visit your Piwigo!\'|@translate}</legend><p class="nextStepLink"><a href="admin.php?page=plugin-TakeATour">{\'Take a tour and discover the features of your Piwigo gallery » Go to the available tours\'|@translate}</a></p></fieldset>';
//$copyright_string .= {\'Except where otherwise noted, content on this wiki is licensed under the following license:\'|translate};
//		 if (!empty($pat))
//			{
				$template->assign('simplecrfooter', $copyright_link);
//			}

// send variables to template
//$template->assign(array(
//  'simplecr_label' => $simplecr_label,
//  'simplecr_url' => $simplecr_url,
//  'simplecr_descr' => $simplecr_descr,
//  ));


	$template->set_filename('simplecrfooter', realpath(SIMPLECR_PATH.'footer.tpl'));	
	$template->append('footer_elements', $template->parse('simplecrfooter', true));
	}
 }

?>
