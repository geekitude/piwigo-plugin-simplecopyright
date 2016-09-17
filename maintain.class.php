<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class SimpleCopyright_maintain extends PluginMaintain {
    private $default_conf = array(
        'select' => 'by-nc-nd',
        'enablefootercr' => true,
        'customlabel' => 'Custom copyright label',
        'customurl' => 'http://custom.sample/full_text',
        'customdescr' => 'Custom copyright short description',
    );

    function install($plugin_version, &$errors=array()) {
        global $conf;

        if (empty($conf['SimpleCopyright'])) {
            conf_update_param('SimpleCopyright', $this->default_conf, true);
        }
    }

// FONCTION A SUPPRIMER UNE FOIS LES OPTIONS FONCTIONNELLES
function activate($plugin_version, &$errors=array()) {
global $conf;
conf_update_param('SimpleCopyright', $this->default_conf, true);
}

// FONCTION A SUPPRIMER UNE FOIS LES OPTIONS FONCTIONNELLES
function deactivate($plugin_version, &$errors=array()) {
conf_delete_param('SimpleCopyright');
}

    function update($old_version, $new_version, &$errors=array()) {
        $this->install($new_version, $errors);
    }

    function uninstall() {
        conf_delete_param('SimpleCopyright');
    }
}

