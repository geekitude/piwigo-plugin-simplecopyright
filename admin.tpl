{footer_script}
    jQuery(document).ready(setSummary);
    jQuery('#simplecr_default_dropdown').change(setSummary);

    function setSummary() {
        var $summary = "";
        var $selected = jQuery('#simplecr_default_dropdown').val();
        if ($selected === "by") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.";
        } else if ($selected === "by-sa") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
        } else if ($selected === "by-nd") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) for any purpose, even commercially. If you remix, transform, or build upon the material, you may not distribute the modified material.";
        } else if ($selected === "by-nc") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit.";
        } else if ($selected === "by-nc-sa") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
        } else if ($selected === "by-nc-nd") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.";
        } else if ($selected === "custom") {
            $summary = "{'see below'|@translate}";
        } else if ($selected === "no-license") {
            $summary = "You have no right to reuse this material in any way. Note that \"All Rights Reserved\" formula does not have any legal value left in any juridiction but is used here to prevent ambiguity.";
        }
        $('#simplecr_descr').text($summary);
    }
{/footer_script}

<!-- Show plugin title -->
<div class="titlePage">
    <h2>{'Simple Copyright plugin'|@translate}</h2>
</div>
 
<!-- Show settings in a nice box -->
<form method="post" action="" class="properties">
    <fieldset>
        <legend>{'Default license'|@translate}</legend>
        <ul>
            <li>
                <label>
                    <b>{'Choice:'|@translate}</b>
                    {html_options id=simplecr_default_dropdown name=select options=$select_options selected=$simplecr.select}
                </label>
            </li>
            <li>
                <b>{'Summary:'|@translate}</b> <i id="simplecr_descr"></i>
            </li>
            <li>
                <label>
                    <input type="checkbox" name="enablefootercr" value="1" {if $simplecr.enablefootercr}checked="checked"{/if}>
                    <b>{'Display default license in site footer'|@translate}</b>
                </label>
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <legend>{'Custom license'|@translate}</legend>
        <ul>
            <li>
                <label>
                    <b>{'Label:'|@translate}</b>
                    <input type='text' name='customlabel' id='customlabel' value='{$simplecr.customlabel|escape}' />
                </label>
                <a class="icon-info-circled-1 showInfo" title="{'Custom license label shown by Piwigo'|@translate}"></a>
            </li>
            <li>
                <label>
                    <b>{'URL:'|@translate}</b>
                    <input type='text' name='customurl' id='customurl' value='{$simplecr.customurl|escape}' />
                </label>
                <a class="icon-info-circled-1 showInfo" title="{'Any license requires a link to a full description to be of any value'|@translate}"></a>
            </li>
            <li>		
                <label>		
                    <b>{'Short description:'|@translate}</b>		
                    <input type='text' name='customdescr' id='customdescr' value='{$simplecr.customdescr|escape}' />		
                </label>		
                <a class="icon-info-circled-1 showInfo" title="{'Will be shown as a tooltip when hovering license link'|@translate}"></a>		
            </li>
         </ul>
    </fieldset>

    <p><img src="plugins/SimpleCopyright/images/important.png" alt="*IMPORTANT*" height="48" width="48" align="middle" style="margin-right: 5px;"><i>{"Note that displaying a copyright and/or a license on a web page isn't as efficient as adding them in picture's metadatas, it only makes them more visible."|@translate}</i></p>

    <p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|@translate}"></p>

</form>
