<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class SimpleCopyright_maintain extends PluginMaintain {
    private $default_conf = array(
        'select' => 'by-nc-nd',
        'enablefootercr' => true,
        'customlabel' => 'Custom license label',
        'customurl' => 'http://custom.sample/full_text',
        'customdescr' => 'Custom license short description',
        'label' => "CC Attribution-NonCommercial-NoDerivatives 4.0 International",
        'url' => "https://creativecommons.org/licenses/by-nc-nd/4.0/",
        'descr' => "You are free to share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.",
    );

    function install($plugin_version, &$errors=array()) {
        global $conf;

        if (empty($conf['SimpleCopyright'])) {
            conf_update_param('SimpleCopyright', $this->default_conf, true);
        }
    }

    function activate($plugin_version, &$errors=array()) {
        global $conf;
        conf_update_param('SimpleCopyright', $this->default_conf, true);
    }

// FONCTION A DESACTIVER UNE FOIS LES OPTIONS FONCTIONNELLES
//function deactivate($plugin_version, &$errors=array()) {
//conf_delete_param('SimpleCopyright');
//}

    function update($old_version, $new_version, &$errors=array()) {
        $this->install($new_version, $errors);
    }

    function uninstall() {
        conf_delete_param('SimpleCopyright');
    }
}

