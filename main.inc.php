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

// Define the path to our plugin.
define('SIMPLECR_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

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
function simplecr_init() {
    global $conf, $simplecr, $simplecr_label, $simplecr_url;

    // prepare plugin configuration
    $simplecr = safe_unserialize($conf['SimpleCopyright']);

    if ($simplecr['select'] == "by") {
        $simplecr_label = "Attribution 4.0 International (CC BY 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by/4.0/";
    } elseif ($simplecr['select'] == "by-sa") {
        $simplecr_label = "Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-sa/4.0/";
    } elseif ($simplecr['select'] == "by-nd") {
        $simplecr_label = "Attribution-NoDerivatives 4.0 International (CC BY-ND 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nd/4.0/";
    } elseif ($simplecr['select'] == "by-nc") {
        $simplecr_label = "Attribution-NonCommercial 4.0 International (CC BY-NC 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nc/4.0/";
    } elseif ($simplecr['select'] == "by-nc-sa") {
        $simplecr_label = "Attribution-NonCommercial-ShareAlike 4.0 International (CC BY-NC-SA 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nc-sa/4.0/";
    } elseif ($simplecr['select'] == "by-nc-nd") {
        $simplecr_label = "Attribution-NonCommercial-NoDerivatives 4.0 International (CC BY-NC-ND 4.0)";
        $simplecr_url = "https://creativecommons.org/licenses/by-nc-nd/4.0/";
    } elseif ($simplecr['select'] == "custom") {
        $simplecr_label = $simplecr['customlabel'];
        $simplecr_url = $simplecr['customurl'];
    }
}

function simplecr_footer() {
    global $page, $template, $simplecr, $simplecr_label, $simplecr_url;
    if (($simplecr['enablefootercr'] == 1) and (script_basename() != 'admin') and ($page['body_id'] != 'thePopuphelpPage')) {
        // load plugin language file
        load_language('plugin.lang', SIMPLECR_PATH);

        $copyright_link = '<a href='.$simplecr_url.' title="See licence">'.$simplecr_label.'</a>';
        
        // send values to template
        $template->assign('simplecrfooter', $copyright_link);
        $template->set_filename('simplecrfooter', realpath(SIMPLECR_PATH.'footer.tpl'));	
        $template->append('footer_elements', $template->parse('simplecrfooter', true));
	}
 }

?>
