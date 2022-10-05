<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class SimpleCopyright_maintain extends PluginMaintain {
    private $default_conf = array(
        'select' => 'no-license',
        'enablefootercr' => true,
        'customlabel' => 'Custom license label',
        'customurl' => 'http://custom.sample/full_text',
        'customdescr' => 'Custom license short description',
        'enableimagecr' => true,
        'license2link' => true,
        'switch2license' => true,
    );

    function install($plugin_version, &$errors=array()) {
        global $conf;

        if (empty($conf['SimpleCopyright'])) {
            conf_update_param('SimpleCopyright', $this->default_conf, true);
        }
    }

    function update($old_version, $new_version, &$errors=array()) {
        $this->install($new_version, $errors);
    }

    function uninstall() {
        conf_delete_param('SimpleCopyright');
    }
}

