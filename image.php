<?php

// Add an event handler for a prefilter
add_event_handler('loc_begin_picture', 'simplecr_set_prefilter_add_to_pic_info', 55 );

// Change the variables used by the function that changes the template
add_event_handler('loc_begin_picture', 'simplecr_add_image_vars_to_template');

// Add the prefilter to the template
function simplecr_set_prefilter_add_to_pic_info()
{
	global $template;
	$template->set_prefilter('picture', 'simplecr_add_to_pic_info');
}

// Insert the template for the copyright display
function simplecr_add_to_pic_info($content, &$smarty)
{
	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';
	
	$replacement = 'class="imageInfoTable">
	<div id="copyright" class="imageInfo">
		<dt>{\'Copyright\'|@translate}</dt>
		<dd>
			<a target="_blanc" href="{$SIMPLECR_URL}" title="{$SIMPLECR_DESCR}">{$SIMPLECR_LABEL}</a>
    </dd>
	</div>';

	return preg_replace($search, $replacement, $content, 1);
}

// Assign values to the variables in the template
function simplecr_add_image_vars_to_template()
{
	global $page, $template, $prefixeTable, $conf;

	// Show block only on the photo page
	if ( !empty($page['image_id']) )
	{
        $simplecr = safe_unserialize($conf['SimpleCopyright']);
        $simplecr_label = $simplecr['label'];
        $simplecr_url = $simplecr['url'];
        $simplecr_descr = $simplecr['descr'];
			
		// Sending data to the template
    $template->assign(
      array	(
        'SIMPLECR_LABEL' => $simplecr_label,
        'SIMPLECR_URL' => $simplecr_url,
        'SIMPLECR_DESCR' => $simplecr_descr
      )
    );
	}
}
?>
