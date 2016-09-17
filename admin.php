<?php
    // Check whether we are indeed included by Piwigo.
    if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

    //include_once(PHPWG_ROOT_PATH.'admin/include/functions.php');
    load_language('plugin.lang', SIMPLECR_PATH);

    // save config
    if (isset($_POST['save_config'])) {
        if ($_POST['select'] == "by") {
            $simplecr_label = "CC Attribution 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.";
        } elseif ($_POST['select'] == "by-sa") {
            $simplecr_label = "CC Attribution-ShareAlike 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-sa/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
        } elseif ($_POST['select'] == "by-nd") {
            $simplecr_label = "CC Attribution-NoDerivatives 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nd/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) for any purpose, even commercially. If you remix, transform, or build upon the material, you may not distribute the modified material.";
        } elseif ($_POST['select'] == "by-nc") {
            $simplecr_label = "CC Attribution-NonCommercial 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nc/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit.";
        } elseif ($_POST['select'] == "by-nc-sa") {
            $simplecr_label = "CC Attribution-NonCommercial-ShareAlike 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nc-sa/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
        } elseif ($_POST['select'] == "by-nc-nd") {
            $simplecr_label = "CC Attribution-NonCommercial-NoDerivatives 4.0 International";
            $simplecr_url = "https://creativecommons.org/licenses/by-nc-nd/4.0/";
            $simplecr_descr = "You are free to share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.";
        } elseif ($_POST['select'] == "custom") {
            $simplecr_label = $_POST['customlabel'];
            $simplecr_url = $_POST['customurl'];
            $simplecr_descr = $_POST['customdescr'];
        }
        $conf['SimpleCopyright'] = array(
            'select' => $_POST['select'],
            'enablefootercr' => isset($_POST['enablefootercr']),
            'customlabel' => $_POST['customlabel'],
            'customurl' => $_POST['customurl'],
            'customdescr' => $_POST['customdescr'],
            'label' => $simplecr_label,
            'url' => $simplecr_url,
            'descr' => $simplecr_descr,
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
