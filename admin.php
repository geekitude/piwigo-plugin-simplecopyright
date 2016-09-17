<?php
    // Check whether we are indeed included by Piwigo.
    if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

    //include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
    load_language('plugin.lang', SIMPLECR_PATH);

    // save config
    if (isset($_POST['save_config'])) {
        $conf['SimpleCopyright'] = array(
            'select' => $_POST['select'],
            'enablefootercr' => isset($_POST['enablefootercr']),
            'customlabel' => $_POST['customlabel'],
            'customurl' => $_POST['customurl'],
            'customdescr' => $_POST['customdescr'],
        );
        conf_update_param('SimpleCopyright', $conf['SimpleCopyright']);
    }

    // Fetch the template.
    global $template, $simplecr_descr;

    // Add our template to the global template
    $template->set_filenames(
        array(
            'plugin_admin_content' => dirname(__FILE__).'/admin.tpl'
        )
    );

    // Base copyright choices
    $select_options = array(
        'by' => l10n('CC BY 4.0'),
        'by-sa' => l10n('CC BY-SA 4.0'),
        'by-nd' => l10n('CC BY-ND 4.0'),
        'by-nc' => l10n('CC BY-NC 4.0'),
        'by-nc-sa' => l10n('CC BY-NC-SA 4.0'),
        'by-nc-nd' => l10n('CC BY-NC-ND 4.0'),
        'custom' => l10n('Custom'),
    );

    // send config to template
    $template->assign(array(
        'simplecr' => safe_unserialize($conf['SimpleCopyright']),
        'simplecr_descr' => $simplecr_descr,
        'select_options' => $select_options
    ));

    // Assign the template contents to ADMIN_CONTENT
    $template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>
