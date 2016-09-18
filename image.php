<?php
// Change the variables used by the function that changes the template (uses default priority wich is 50)
add_event_handler('loc_begin_picture', 'simplecr_add_image_vars_to_template');
// Add an event handler for a prefilter (will occure after previous event hook since priority is higher)
add_event_handler('loc_begin_picture', 'simplecr_set_prefilter_add_to_pic_info', 55 );

// Assign values to the variables in the template
function simplecr_add_image_vars_to_template() {
	global $page, $template, $conf, $mediacr;

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
        $mediacr = $iptc['2#116'][0];
    }

	// Show block only on the picture page
	if ( !empty($page['image_id']) ) {
        $simplecr = safe_unserialize($conf['SimpleCopyright']);
        $simplecr_label = $simplecr['label'];
        $simplecr_url = $simplecr['url'];
        $simplecr_descr = $simplecr['descr'];
			
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
	global $template;
	$template->set_prefilter('picture', 'simplecr_add_to_pic_info');
}

// Insert the template for the copyright display
function simplecr_add_to_pic_info($content, &$smarty) {
    global $mediacr;

    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';
	
    // Replacement to add Simple Copyright default copyright...
    if ($mediacr == NULL) {
        $replacement = 'class="imageInfoTable">
        <div id="simplecr" class="imageInfo">
            <dt>{\'Copyright\'|@translate}</dt>
            <dd>
                <a target="_blank" href="{$SIMPLECR_URL}" title="{$SIMPLECR_DESCR}">{$SIMPLECR_LABEL}</a>
            </dd>
        </div>';
    // ... or replacement to add picture's IPTC copyright
    } else {
        $replacement = 'class="imageInfoTable">
        <div id="simplecr" class="imageInfo">
            <dt>{\'Copyright\'|@translate}</dt>
            <dd>
                {$MEDIA_CR}
            </dd>
        </div>';
    }
	return preg_replace($search, $replacement, $content, 1);
}

?>
