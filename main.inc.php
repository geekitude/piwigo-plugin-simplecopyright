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

/* +-----------------------------------------------------------------------+
 * | Plugin admin                                                          |
 * +-----------------------------------------------------------------------+ */

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
        global $conf, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr;

        // prepare plugin configuration
        $simplecr = safe_unserialize($conf['SimpleCopyright']);

        if ($simplecr['select'] == "by") {
            $simplecr_label = "CC Attribution 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.";
        } elseif ($simplecr['select'] == "by-sa") {
            $simplecr_label = "CC Attribution-ShareAlike 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-sa/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
        } elseif ($simplecr['select'] == "by-nd") {
            $simplecr_label = "CC Attribution-NoDerivatives 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nd/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) for any purpose, even commercially. If you remix, transform, or build upon the material, you may not distribute the modified material.";
        } elseif ($simplecr['select'] == "by-nc") {
            $simplecr_label = "CC Attribution-NonCommercial 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nc/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit.";
        } elseif ($simplecr['select'] == "by-nc-sa") {
            $simplecr_label = "CC Attribution-NonCommercial-ShareAlike 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nc-sa/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
        } elseif ($simplecr['select'] == "by-nc-nd") {
            $simplecr_label = "CC Attribution-NonCommercial-NoDerivatives 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nc-nd/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.";
        } elseif ($simplecr['select'] == "custom") {
            $simplecr_label = $simplecr['customlabel'];
            $simplecr_url = $simplecr['customurl'];
            $simplecr_descr = $simplecr['customdescr'];
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

/* +-----------------------------------------------------------------------+
 * | Plugin image                                                          |
 * +-----------------------------------------------------------------------+ */

// Add information to the picture's description (The copyright's name)
include_once(dirname(__FILE__).'/image.php');

?>
