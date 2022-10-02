{footer_script}
    jQuery(document).ready(setSummary);
    jQuery('#simplecr_default_dropdown').change(setSummary);

    function setSummary() {
        var $summary = "";
        var $selected = jQuery('#simplecr_default_dropdown').val();
        if ($selected === "by") {
            $summary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.";
        } else if ($selected === "by-sa") {
            $summary = {'descr_by-sa'|@translate}
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
    <fieldset>
        <legend>{'Image pages'|@translate}</legend>
        <ul>
            <li>
                <label>
                    <input type="checkbox" name="enableimagecr" value="1" {if ($simplecr.enableimagecr)}checked="checked"{/if}>
                    <b>{'Display image page Copyright section'|@translate}</b>.
                </label>
            </li>
            <li>
                <label>
                    <input type="checkbox" name="license2link" value="1" {if ($simplecr.license2link)}checked="checked"{/if}>
                    <b>{'Turn recognizable license label in Copyright metadata into a link to that license details'|@translate}</b>. {'Examples of recognizable license labels:'|@translate} <i>CC BY 4.0</i>, <i>CC Attribution 4.0 International</i>, <i>CC Attribution 4.0</i>, <i>CC BY-SA 4.0</i>, <i>CC Attribution-ShareAlike 4.0 International</i>, <i>CC Attribution-ShareAlike 4.0</i>, <i>All Rights Reserved</i>, ...
                </label>
            </li>
            <li>
                <label>
                    <input type="checkbox" name="switch2license" value="1" {if ($simplecr.switch2license)}checked="checked"{/if}>
                    <b>{'If image has no Copyright info, display a License section instead (with a link to default license)'|@translate}</b>.
                </label>
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <legend>{'About copyright notice'|@translate}</legend>
        {"Elements legally required to correctly present a Copyright in most countries:"|@translate}<br/>
        <ul>
            <li style="margin: 0;">
                1- {"the © symbol (C letter in a circle), the word “Copyright”, or the abbreviation “Copr.”"|@translate}<a class="icon-info-circled-1 showInfo" title="{'Note that the abbreviation might not be acceptable in some countries'|@translate}"></a>
            </li>
            <li style="margin: 0;">
                2- {"the year of first publication"|@translate}
            </li>
            <li style="margin: 0;">
                3- {"the name of the copyright owner, an abbreviation by which the name can be recognized, or a notoriously known alternative designation of owner"|@translate}
            <li>
        </ul>
        <i>{"Excerpt from"|@translate} <a href="https://en.wikipedia.org/wiki/Copyright_notice#Form_of_notice_for_visually_perceptible_copies" target="_blank" title="Wikipedia">{"this Wikipedia article"|@translate}</a>.</i>
        <div style="margin-top: 15px;">{"It is possible and often advised (or even required in some countries) to add the licence after the Copyright, here come a few examples:"|@translate} <i>@2008 John SNOW (All Rights Reserved)</i>, <i>@2008 John SNOW - CC Attribution-NoDerivatives 4.0 International</i>, ...</div>
    </fieldset>

    <p><img src="plugins/SimpleCopyright/images/important.png" alt="*IMPORTANT*" height="48" width="48" align="middle" style="margin-right: 5px;"><i>{"Note that displaying a copyright and/or a license on a web page isn't as legally efficient as adding them in picture's metadatas, it only makes them more visible."|@translate}</i></p>

    <p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|@translate}"></p>

</form>
