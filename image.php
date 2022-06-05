<?php
    
// Change the variables used by the function that changes the template (uses default priority which is 50)
add_event_handler('loc_begin_picture', 'simplecr_add_image_vars_to_template');
// Add an event handler for a prefilter (will occure after previous event hook since priority is higher)
add_event_handler('loc_begin_picture', 'simplecr_set_prefilter_add_to_pic_info', 55 );

// Assign values to the variables in the template
function simplecr_add_image_vars_to_template() {
	//global $page, $template, $conf, $mediacr ;
	global $page, $template, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr, $mediacr ;

    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

    //$simplecr = safe_unserialize($conf['SimpleCopyright']);

    // Get media id and filename
    $media_id = $page['image_id'];
	$query = 'select id,name,file,path FROM ' . IMAGES_TABLE . ' WHERE id = \''.$media_id.'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$filename=$row['path'];
	// Get media IPTC copyright
	$imginfo = array();
	getimagesize($filename, $imginfo);
	if (isset($imginfo['APP13'])){
        $iptc = iptcparse($imginfo['APP13']);
        if (isset($iptc['2#116'][0])) {
            $mediacr = $iptc['2#116'][0];
        }
    }

    if ($simplecr['license2link'] == true) {
        $mediacr = str_replace(array('CC Attribution 4.0 International', 'CC BY 4.0 International', 'CC BY 4.0'), '<a target="_blank" href="'.l10n('url_by').'" title="'.l10n('descr_by').'">CC BY 4.0</a>', $mediacr);
        $mediacr = str_replace(array('CC Attribution-ShareAlike 4.0 International', 'CC BY-SA 4.0 International', 'CC BY-SA 4.0'), '<a target="_blank" href="'.l10n('url_by-sa').'" title="'.l10n('descr_by-sa').'">CC BY-SA 4.0</a>', $mediacr);
        $mediacr = str_replace(array('CC Attribution-NoDerivatives 4.0 International', 'CC BY-ND 4.0 International', 'CC BY-ND 4.0'), '<a target="_blank" href="'.l10n('url_by-nd').'" title="'.l10n('descr_by-nd').'">CC BY-ND 4.0</a>', $mediacr);
        $mediacr = str_replace(array('CC Attribution-NonCommercial 4.0 International', 'CC BY-NC 4.0 International', 'CC BY-NC 4.0'), '<a target="_blank" href="'.l10n('url_by-nc').'" title="'.l10n('descr_by-nc').'">CC BY-NC 4.0</a>', $mediacr);
        $mediacr = str_replace(array('CC Attribution-NonCommercial-ShareAlike 4.0 International', 'CC BY-NC-SA 4.0 International', 'CC BY-NC-SA 4.0'), '<a target="_blank" href="'.l10n('url_by-nc-sa').'" title="'.l10n('descr_by-nc-sa').'">CC BY-NC-SA 4.0</a>', $mediacr);
        $mediacr = str_replace(array('CC Attribution-NonCommercial-NoDerivatives 4.0 International', 'CC BY-NC-ND 4.0 International', 'CC BY-NC-ND 4.0'), '<a target="_blank" href="'.l10n('url_by-nc-nd').'" title="'.l10n('descr_by-nc-nd').'">CC BY-NC-ND 4.0</a>', $mediacr);
        $mediacr = str_replace($simplecr['customlabel'], '<a target="_blank" href="'.$simplecr['customurl'].'" title="'.$simplecr['customdescr'].'">'.$simplecr['customlabel'].'</a>', $mediacr);
        $mediacr = str_replace(array('All Rights Reserved', 'Tous droits réservés',), '<a target="_blank" href="'.l10n('url_no-license').'" title="'.l10n('descr_no-license').'">'.l10n('label_no-license').'</a>', $mediacr);
    }

	// Show block only on the picture page
	if ( !empty($page['image_id']) ) {
		// Sending data to the template
        $template->assign(
            array	(
                'SIMPLECR_LABEL' => $simplecr_label,
                'SIMPLECR_URL' => $simplecr_url,
                'SIMPLECR_DESCR' => $simplecr_descr,
                'MEDIA_CR' => $mediacr
            )
        );
	}
}

// Add the prefilter to the template
function simplecr_set_prefilter_add_to_pic_info() {
	//global $template, $conf, $mediacr;
	global $template, $simplecr, $mediacr;

    // prepare plugin configuration
    //$simplecr = safe_unserialize($conf['SimpleCopyright']);

    if ((isset($simplecr['enableimagecr'])) and ($simplecr['enableimagecr'] == true)) {
        if ($mediacr != null) {
            $template->set_prefilter('picture', 'simplecr_add_pic_copyright');
        } 
        elseif (($mediacr == NULL) and ((isset($simplecr['switch2license'])) and ($simplecr['switch2license'] == true))) {
            $template->set_prefilter('picture', 'simplecr_add_pic_license');
        }
    }
}

// Insert the template for the copyright display
function simplecr_add_pic_copyright($content) {
    global $mediacr;
    // prepare plugin configuration
    //$simplecr = safe_unserialize($conf['SimpleCopyright']);

    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

//https://creativecommons.org/licenses/by-nc-nd/4.0/
	// Add the information after the author - so before the createdate
	$search = array(
        '#class="imageInfoTable">#', // default theme
        '#id="PictureInfo">#', // smartpocket theme
        '#id="info-content" class="d-flex flex-column">#', // bootstrap_darkroom theme
    );

    // Replacement to add Simple Copyright default copyright...
    $replacement = array(
        // default theme
        'class="imageInfoTable">
    <div id="simplecr" class="imageInfo">
        <dt>{\'Copyright\'|@translate}</dt>
        <dd>
            {$MEDIA_CR}
        </dd>
    </div>',
        // smartpocket theme
        'id="PictureInfo">
    <li id="simplecr" class="imageInfo">
        <dt>{\'Copyright\'|@translate}</dt>
        <dd>{$MEDIA_CR}</dd>
    </li>',
        // bootstrap_darkroom theme
        'id="info-content" class="d-flex flex-column">
    <div id="simplecr" class="imageInfo">
        <dl class="row mb-0">
            <dt class="col-sm-5">{\'Copyright\'|@translate}</dt>
            <dd class="col-sm-7">
                {$MEDIA_CR}
            </dd>
        </dl>
    </div>',
    );
	return preg_replace($search, $replacement, $content, 1);
}

// Insert the template for the license display
function simplecr_add_pic_license($content) {
    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';

    // Replacement to add Simple Copyright default license (admins get a special alert to draw their attention to the fact image has no Copyright in metadata)...
    if (!is_admin()) {
        $replacement = 'class="imageInfoTable">
        <div id="simplecr" class="imageInfo">
            <dt>{\'License\'|@translate}</dt>
            <dd>
                <a target="_blank" href="{$SIMPLECR_URL}" title="{$SIMPLECR_DESCR}">{$SIMPLECR_LABEL}</a>
            </dd>
        </div>';
    } else {
        $replacement = 'class="imageInfoTable">
        <div id="simplecr" class="imageInfo">
            <dt>{\'License\'|@translate}</dt>
            <dd>
                <a target="_blank" href="{$SIMPLECR_URL}" title="{$SIMPLECR_DESCR}">{$SIMPLECR_LABEL}</a> <img src="plugins/SimpleCopyright/images/important.png" width="16" style="margin: 0 0 -3px 3px;" title="{\'Image does not contain any Copyright, it would be wise to add one in metadata.\'|@translate}" />
            </dd>
        </div>';
    }
	return preg_replace($search, $replacement, $content, 1);
}

?>
