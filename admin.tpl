{footer_script}
jQuery('#simplecr_default_dropdown').change(function() {
    var $sumary = "";
    var $selected = $(this).val();
    if ($selected === "by") {
        $sumary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit.";
    } else if ($selected === "by-sa") {
        $sumary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any purpose, even commercially but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
    } else if ($selected === "by-nd") {
        $sumary = "You are free to share (copy and redistribute the material in any medium or format) for any purpose, even commercially. If you remix, transform, or build upon the material, you may not distribute the modified material.";
    } else if ($selected === "by-nc") {
        $sumary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit.";
    } else if ($selected === "by-nc-sa") {
        $sumary = "You are free to share (copy and redistribute the material in any medium or format) or adapt (remix, transform, and build upon the material) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you must distribute your contributions under the same license as the original.";
    } else if ($selected === "by-nc-nd") {
        $sumary = "You are free to share (copy and redistribute the material in any medium or format) for any non-commercial purpose but must give appropriate credit. If you remix, transform, or build upon the material, you may not distribute the modified material.";
    }
  $('#simplecr_descr').text($sumary);
});
{/footer_script}

<!-- Show the title of the plugin -->
<div class="titlePage">
 <h2>{'Simple Copyright plugin'|@translate}</h2>
</div>
 
<!-- Show content in a nice box -->
<form method="post" action="" class="properties">
    <fieldset>
        <legend>{'Default copyright'|@translate}</legend>
        <ul>
            <li>
                <label>
                    <b>{'Choice:'|translate}</b>
                    {html_options id=simplecr_default_dropdown name=select options=$select_options selected=$simplecr.select}
                </label>
            </li>
            <li>
                <b>{'Summary:'|translate}</b> <i id="simplecr_descr">{$simplecr_descr}</i>
            </li>
            <li>
                <label>
                    <input type="checkbox" name="enablefootercr" value="1" {if $simplecr.enablefootercr}checked="checked"{/if}>
                    <b>{'Show default copyright in site footer'|@translate}</b>
                </label>
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <legend>{'Custom copyright'|@translate}</legend>
        <ul>
            <li>
                <label>
                    <b>{'Label :'|translate}</b>
                    <input type='text' name='customlabel' id='customlabel' value='{$simplecr.customlabel|escape}' />
                </label>
                <a class="icon-info-circled-1 showInfo" title="{'Custom copyright label shown by Piwigo'|@translate}"></a>
            </li>
            <li>
                <label>
                    <b>{'URL :'|translate}</b>
                    <input type='text' name='customurl' id='customurl' value='{$simplecr.customurl|escape}' />
                </label>
                <a class="icon-info-circled-1 showInfo" title="{'Any copyright requires a link to a full description to be of any value'|@translate}"></a>
            </li>
            <li>		
                <label>		
                    <b>{'Short description :'|translate}</b>		
                    <input type='text' name='customdescr' id='customdescr' value='{$simplecr.customdescr|escape}' />		
                </label>		
                <a class="icon-info-circled-1 showInfo" title="{'Will be shown as a tooltip when hovering copyright link'|@translate}"></a>		
            </li>
         </ul>
    </fieldset>

    <p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|translate}"></p>

</form>
