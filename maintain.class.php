<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class SimpleCopyright_maintain extends PluginMaintain {
    private $default_conf = array(
        'select' => 'no-license',
        'enablefootercr' => true,
        'customlabel' => 'Custom license label',
        'customurl' => 'http://custom.sample/full_text',
        'customdescr' => 'Custom license short description',
        'label' => "All Rights Reserved",
        'url' => "https://en.wikipedia.org/wiki/All_rights_reserved",
        'descr' => "There is no license granting you with any right to reuse any material from this website in any way, refer to copyrights. Note that 'All Rights Reserved' formula does not have any legal value left in any juridiction but is used here to prevent ambiguity.",
    );

    function install($plugin_version, &$errors=array()) {
        global $conf;

        if (empty($conf['SimpleCopyright'])) {
            conf_update_param('SimpleCopyright', $this->default_conf, true);
        }
    }

    function activate($plugin_version, &$errors=array()) {
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

