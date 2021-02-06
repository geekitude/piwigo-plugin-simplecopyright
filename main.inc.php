<?php
/*
Version: 3.02
Plugin Name: Simple Copyright
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=839
Author: Geekitude
Description: Affichage d'un copyright de base en respectant le champs IPTC correspondant s'il existe.
Has Settings: true
*/

    // Check whether we are indeed included by Piwigo.
    if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
    global $conf, $simplecr ;

    // prepare plugin configuration
    $simplecr = safe_unserialize($conf['SimpleCopyright']);

    // Define the path to our plugin.
    define('SIMPLECR_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

    // Hook on to an event to show the administration page.
    add_event_handler('get_admin_plugin_menu_links', 'simplecr_admin_menu');
    add_event_handler('init', 'simplecr_init');
    add_event_handler('loc_end_page_tail', 'simplecr_footer', 40);


/* +-----------------------------------------------------------------------+
 * | Admin Page                                                            |
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
        //global $conf, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr;
        global $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr;

        //// prepare plugin configuration
        //$simplecr = safe_unserialize($conf['SimpleCopyright']);

        // load plugin language file
        load_language('plugin.lang', SIMPLECR_PATH);
        switch ( $simplecr['select'] ) {
        case 'custom' :
            $simplecr_label = $simplecr['customlabel'];
            $simplecr_url   = $simplecr['customurl'];
            $simplecr_descr = $simplecr['customdescr'];
            break ;
        case 'by' :
        case 'by-sa' :
        case 'by-nd' :
        case 'by-nc' :
        case 'by-nc-sa' :
        case 'by-nc-nd' :
        case 'no-license' :
            $simplecr_label = l10n('label_'.$simplecr['select']) ;
            $simplecr_url   = l10n('url_'  .$simplecr['select']) ; 
            $simplecr_descr = l10n('descr_'.$simplecr['select']) ;
            break ;
        }
    }

    function simplecr_footer() {
        global $page, $template, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr, $lang;

        if (($simplecr['enablefootercr'] == 1) and (script_basename() != 'admin') and ($page['body_id'] != 'thePopuphelpPage')) {

            $copyright_link = '<a href='.$simplecr_url.' target="_blank" title="'.$simplecr_descr.'">'.$simplecr_label.'</a>';
        
            // send values to template
            $template->assign('simplecrfooter', $copyright_link);
            if ($simplecr['select'] == "no-license") {
                $template->set_filename('simplecrfooter', realpath(SIMPLECR_PATH.'footer_no-license.tpl'));
            } else {
                $template->set_filename('simplecrfooter', realpath(SIMPLECR_PATH.'footer.tpl'));
            }
            $template->append('footer_elements', $template->parse('simplecrfooter', true));
        }
    }

/* +-----------------------------------------------------------------------+
 * | Image Page                                                            |
 * +-----------------------------------------------------------------------+ */

// Add information to the picture's description (The copyright's name)
include_once(dirname(__FILE__).'/image.php');

?>
