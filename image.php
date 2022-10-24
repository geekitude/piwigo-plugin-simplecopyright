<?php

// Change the variables used by the function that changes the template (uses default priority which is 50)
add_event_handler('loc_begin_picture', 'simplecr_add_image_vars_to_template');
// Add an event handler for a prefilter (will occure after previous event hook since priority is higher)
add_event_handler('loc_begin_picture', 'simplecr_set_prefilter_add_to_pic_info', 55 );

// Assign values to the variables in the template
function simplecr_add_image_vars_to_template() {
	global $page, $template, $simplecr, $simplecr_label, $simplecr_url, $simplecr_descr, $simplecr_about, $mediacr;

    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

    // Get media id and filename
    $media_id = $page['image_id'];
	$query = 'select id,name,file,path FROM ' . IMAGES_TABLE . ' WHERE id = \''.$media_id.'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$filename = $row['path'];

    if ((isset($simplecr['imageabout'])) and ($simplecr['imageabout'] == 1)) { $simplecr_about['uri'] = ltrim($filename, "."); }

    // Get media EXIF copyright
    $exifcr = null;
    $exif = exif_read_data($filename, 'EXIF');
    if (isset($exif['COMPUTED']['Copyright'])) {
        $exifcr = $exif['COMPUTED']['Copyright'];
    }

	// Get media IPTC copyright
    $iptccr = null;
	$imginfo = array();
	getimagesize($filename, $imginfo);
	if (isset($imginfo['APP13'])){
        $iptc = iptcparse($imginfo['APP13']);
        if (isset($iptc['2#116'][0])) {
            $iptccr = $iptc['2#116'][0];
        }
    }

    $crconflict = null;
    if (isset($iptccr) and ($iptccr != null))
    {
        $mediacr = $iptccr;
        if (isset($exifcr) && ($exifcr != null) && ($exifcr == $iptccr))
        {
            $crconflict =  '<img src="'.SIMPLECR_PATH.'images/important.png" width="16" style="margin: 0 0 -3px 3px;" title="'.l10n('copyright-conflict').'" />';
        }
    } elseif (isset($exifcr) and ($exifcr != null))
    {
        $mediacr = $exifcr;
    }

    if ($simplecr['license2link'] == true) {
        switch (true){
            case stristr($mediacr, 'BY-NC-ND'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_by-nc-nd').'" title="'.l10n('descr_by-nc-nd').'"><img src="'.SIMPLECR_PATH.'images/by-nc-nd.png" /><span>'.l10n('label_by-nc-nd').'</span></a>';
                break;
            case stristr($mediacr, 'BY-NC-SA'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_by-nc-sa').'" title="'.l10n('descr_by-nc-sa').'"><img src="'.SIMPLECR_PATH.'images/by-nc-sa.png" /><span>'.l10n('label_by-nc-sa').'</span></a>';
                break;
            case stristr($mediacr, 'BY-NC'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_by-nc').'" title="'.l10n('descr_by-nc').'"><img src="'.SIMPLECR_PATH.'images/by-nc.png" /><span>'.l10n('label_by-nc').'</span></a>';
                break;
            case stristr($mediacr, 'BY-ND'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_by-nd').'" title="'.l10n('descr_by-nd').'"><img src="'.SIMPLECR_PATH.'images/by-nd.png" /><span>'.l10n('label_by-nd').'</span></a>';
                break;
            case stristr($mediacr, 'BY-SA'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_by-sa').'" title="'.l10n('descr_by-sa').'"><img src="'.SIMPLECR_PATH.'images/by-sa.png" /><span>'.l10n('label_by-SA').'</span></a>';
                break;
            case stristr($mediacr, 'BY'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_by').'" title="'.l10n('descr_by').'"><img src="'.SIMPLECR_PATH.'images/by.png" /><span>'.l10n('label_by').'</span></a>';
                break;
            case stristr($mediacr, 'CC0'):
            case stristr($mediacr, 'public'):
                $mediacr = '<a class="cc" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_cc').'" title="'.l10n('descr_cc').'"><img src="'.SIMPLECR_PATH.'images/cc-zero.png" /><span>'.l10n('label_cc').'</span></a>';
                break;
            case stristr($mediacr, $simplecr['customlabel']):
                $mediacr = '<a class="cc custom" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.$simplecr['customurl'].'" title="'.$simplecr['customdescr'].'">'.$simplecr['customlabel'].'</a>';
                break;
            default:
                $mediacr = '<a class="cc nolicense" rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="'.l10n('url_no-license').'" title="'.l10n('descr_no-license').'">'.l10n('label_no-license').'</a>';
        }
    }
    $mediacr .= $crconflict;

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
	global $template, $simplecr, $mediacr;

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

    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

	// Add the information after the author - so before the createdate
	$search = array(
        '#class="imageInfoTable">#', // default theme
        '#id="info-content" class="d-flex flex-column">#', // bootstrap_darkroom theme
        '#id="standard" class="imageInfoTable dl-horizontal">#', // greydragon theme
        '#id="imageInfoLeft">#', // luciano theme
        '#id="PictureInfo">#', // smartpocket theme
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
        // greydragon theme
        'id="standard" class="imageInfoTable dl-horizontal">
            <dt>{\'Copyright\'|@translate}</dt>
            <dd>
                {$MEDIA_CR}
            </dd>',
        // luciano theme
        'id="imageInfoLeft"
    <div id="simplecr" class="imageInfo">
        <span>{\'Copyright\'|@translate}</span>
        <span>
            {$MEDIA_CR}
        </span>
    </div>
    <ul class="nav nav-pills tabs">',
        // smartpocket theme
        'id="PictureInfo">
    <li id="simplecr" class="imageInfo">
        <dt>{\'Copyright\'|@translate}</dt>
        <dd>{$MEDIA_CR}</dd>
    </li>',
    );
	return preg_replace($search, $replacement, $content, 1);
}

// Insert the template for the license display
function simplecr_add_pic_license($content) {
    global $simplecr_about;
    // Load plugin language file
    load_language('plugin.lang', SIMPLECR_PATH);

	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';

    // Replacement to add Simple Copyright default license (admins get a special alert to draw their attention to the fact image has no Copyright in metadata)...
    if (is_admin()) {
        $replacement = 'class="imageInfoTable">
        <div id="simplecr" class="imageInfo">
            <dt>{\'License\'|@translate}</dt>
            <dd>
                <a rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="{$SIMPLECR_URL}" title="{$SIMPLECR_DESCR}">{$SIMPLECR_LABEL}</a> <img src="'.SIMPLECR_PATH.'images/important.png" width="16" style="margin: 0 0 -3px 3px;" title="{\'no-meta-copyright\'|@translate}" />
            </dd>
        </div>';
    } else {
        $replacement = 'class="imageInfoTable">
        <div id="simplecr" class="imageInfo">
            <dt>{\'License\'|@translate}</dt>
            <dd>
                <a rel="license" about="'.$simplecr_about['url'].$simplecr_about['uri'].'" target="_blank" href="{$SIMPLECR_URL}" title="{$SIMPLECR_DESCR}">{$SIMPLECR_LABEL}</a>
            </dd>
        </div>';
    }
	return preg_replace($search, $replacement, $content, 1);
}

?>
