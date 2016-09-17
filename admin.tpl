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
                    <b>{'Choice :'|translate}</b>
                    {html_options name=select options=$select_options selected=$simplecr.select}
                </label>
                <i>Blah blah blah</i>
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
