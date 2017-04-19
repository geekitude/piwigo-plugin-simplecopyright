<?php
// Change the variables used by the function that changes the template (uses default priority which is 50)
add_event_handler('loc_begin_picture', 'simplecr_add_image_vars_to_template');
// Add an event handler for a prefilter (will occure after previous event hook since priority is higher)
add_event_handler('loc_begin_picture', 'simplecr_set_prefilter_add_to_pic_info', 55 );

// Assign values to the variables in the template
function simplecr_add_image_vars_to_template() {
	//global $page, $template, $conf, $mediacr, $currimglicense;
	global $page, $template, $simplecr, $mediacr, $currimglicense;

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
        $mediacr = str_replace(array("CC Attribution 4.0 International", "CC BY 4.0 International", "CC BY 4.0"), "<a target='_blank' href='https://creativecommons.org/licenses/by/4.0/' title='You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.'>CC BY 4.0</a>", $mediacr);
        $mediacr = str_replace(array("CC Attribution-ShareAlike 4.0 International", "CC BY-SA 4.0 International", "CC BY-SA 4.0"), "<a target='_blank' href='https://creativecommons.org/licenses/by-sa/4.0/' title='You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.'>CC BY-SA 4.0</a>", $mediacr);
        $mediacr = str_replace(array("CC Attribution-NoDerivatives 4.0 International", "CC BY-ND 4.0 International", "CC BY-ND 4.0"), "<a target='_blank' href='https://creativecommons.org/licenses/by-nd/4.0/' title='You are free to share (copy and redistribute the material in any medium or format) for any purpose, even commercially. If you remix, transform, or build upon the material, you may not distribute the modified material.'>CC BY-ND 4.0</a>", $mediacr);
        $mediacr = str_replace(array("CC Attribution-NonCommercial 4.0 International", "CC BY-NC 4.0 International", "CC BY-NC 4.0"), "<a target='_blank' href='https://creativecommons.org/licenses/by-nc/4.0/' title='You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit.'>CC BY-NC 4.0</a>", $mediacr);
        $mediacr = str_replace(array("CC Attribution-NonCommercial-ShareAlike 4.0 International", "CC BY-NC-SA 4.0 International", "CC BY-NC-SA 4.0"), "<a target='_blank' href='https://creativecommons.org/licenses/by-nc-sa/4.0/' title='You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.'>CC BY-NC-SA 4.0</a>", $mediacr);
        $mediacr = str_replace(array("CC Attribution-NonCommercial-NoDerivatives 4.0 International", "CC BY-NC-ND 4.0 International", "CC BY-NC-ND 4.0"), "<a target='_blank' href='https://creativecommons.org/licenses/by-nc-nd/4.0/' title='You are free to share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.'>CC BY-NC-ND 4.0</a>", $mediacr);
        $mediacr = str_replace($simplecr['customlabel'], "<a target='_blank' href='".$simplecr['customurl']."' title='".$simplecr['customdescr']."'>".$simplecr['customlabel']."</a>", $mediacr);
        $mediacr = str_replace("All Rights Reserved", "<a target='_blank' href='https://en.wikipedia.org/wiki/All_rights_reserved' title='There is no license granting you with any right to reuse any material from this website in any way, refer to copyrights. Note that « All Rights Reserved » formula does not have any legal value left in any juridiction but is used here to prevent ambiguity.'>All Rights Reserved</a>", $mediacr);
    }

	// Show block only on the picture page
	if ( !empty($page['image_id']) ) {
		// Sending data to the template
        $template->assign(
            array	(
                'SIMPLECR_LABEL' => $simplecr['label'],
                'SIMPLECR_URL' => $simplecr['url'],
                'SIMPLECR_DESCR' => $simplecr['descr'],
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
        } elseif (($mediacr == NULL) and ((isset($simplecr['switch2license'])) and ($simplecr['switch2license'] == true))) {
            $template->set_prefilter('picture', 'simplecr_add_pic_license');
        }
    }
}

// Insert the template for the copyright display
function simplecr_add_pic_copyright($content, &$smarty) {
    global $mediacr;
    // prepare plugin configuration
    //$simplecr = safe_unserialize($conf['SimpleCopyright']);

    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

//https://creativecommons.org/licenses/by-nc-nd/4.0/
	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';

    // Replacement to add Simple Copyright default copyright...
    $replacement = 'class="imageInfoTable">
    <div id="simplecr" class="imageInfo">
        <dt>{\'Copyright\'|@translate}</dt>
        <dd>
            {$MEDIA_CR}
        </dd>
    </div>';
	return preg_replace($search, $replacement, $content, 1);
}

// Insert the template for the license display
function simplecr_add_pic_license($content, &$smarty) {
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
