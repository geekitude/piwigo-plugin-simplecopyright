# piwigo-plugin-simplecopyright

This Piwigo plugin is meant to add a site-wide default license (between base footer and Perso Footer plugin's section) and to show copyright on picture page (between ```author``` and ```creation date fields```) but latest will default to picture's IPTC copyright if it exists. It is possible to choose beetween [Creative Commons](https://creativecommons.org/licenses/) licences (International version 4.0) or any other licence publicly available on internet (through ```Custom copyright``` setting) or no license at all (which means any picture with a correct Copyright is fully protected by Copyright law).

Note that after installation, plugin is set to ```No license``` by default as it seems better to provide higher protection untill user decides otherwise.

If you want to hide license pictogram on image page, use LocalFiles Editor plugin to add this CSS rule :
```css
#simplecr a.cc img {
display: none;
}
```

* [Plugin page](https://piwigo.org/ext/extension_view.php?eid=839)
* [Translation](https://piwigo.org/translate/project.php?project=simplecopyright) (comming soon)
* Directory name in `plugins\` Piwigo folder : SimppleCopyright

# Theme Compatibility

The plugin should work with most themes (please report any incompatibility so that I can try to fix it) but may need some CSS adjustments to improve visual integration (see a few exemples below).

## Known issues

Issues I haven't been able to fix yet, [see Github issues](https://github.com/geekitude/piwigo-plugin-simplecopyright/issues)

### Greydragon

Nothing shows up at all. :(

### Simple NG

Image's license doesn't show on image pages.

### Stripped

Footer license doesn't show on image pages, only at home or album pages.

Note that there's no problem with Stripped & Columns (aka stripped_bacl_bloc) or Stripped Responsive.

## CSS adjustments

LocalFiles Editor plugin is your friend to customize CSS to improve design depending on theme (base design was initially based on Modus but a lot of themes needed same minor adjustment so I changed my mind).

### Bootstrap Darkroom

```css
#wrapper .copyright.container #simplecrfooter {
    display: block;
}
```

### Elegant

```css
@media screen and (max-width: 1000px) {
    #copyright #simplecrfooter::before {
        content: "";
    }
    #copyright #simplecrfooter {
        margin: none;
        max-width: 100%;
    }
}
```

### hr_os

```css
#copyright #simplecrfooter::before {
    content: "";
}
#copyright #simplecrfooter {
    display: block;
}
```

###  Luciano

```css
#imageInfoLeft a.cc img {
  vertical-align: middle;
}
[dir=ltr] #imageInfoLeft a.cc img {
  margin: 0 6px 0 8px;
}
[dir=rtl] #imageInfoLeft a.cc img {
  margin: 0 8px 0 6px;
}
@media screen and (max-width: 1000px) {
    #copyright #simplecrfooter {
        margin: 0;
    }
}
```

###  Modus

```css
@media screen and (max-width: 1000px) {
    #copyright #simplecrfooter::before {
        content: " - ";
    }
}
```

###  P0w0

```css
#imageInfos a.cc img {
  vertical-align: -10px;
}
```

###  Pure

```css
@media screen and (max-width: 1000px) {
    #copyright #simplecrfooter::before {
        display: initial;
        content: " - ";
    }
    #copyright #simplecrfooter {
        display: initial;
    }
}
```

### Stripped

```css
#footer #footer_left {
    min-width: 70%;
    text-align: left;
}
#footer #footer_left > * {
    margin-top: 1px;
    margin-bottom: 1px;
}
#footer #footer_left #simplecrfooter {
    display: table-row;
}
#Tinfo #simplecr {
    display: flex;
}
#Tinfo #simplecr dt {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
```

# Revisions

* [12.i] Fix pictogram url bug again :(
* [12.h] Fix a pictogram url bug that occurs on some piwigo installations
* [12.g]
  * Added CC0 license (image license must contain `cc0` or `public` to be recognized)
  * Improved theme compatibility
  * Improved license-to-link recognition (defaults to `all-rights-reserved` if no CC or custom license is detected)
  * Added pictograms to image licenses
  * Footer license link `about` always points to page URL but you can choose if image metadata license link should point to full size image
  * Slightly improved licenses hover description readability
* [12.f] Revert to 12.b code
* [12.d] then [12.e] Non working fixes for 12.c admin dropdown JSON error
* [12.c]
  * Improved license-to-link recognition (defaults to `all-rights-reserved` if no CC or custom license is detected)
  * Footer license link `about` always points to page URL but you can choose if image metadata license link should point to full size image
  * Added pictograms to image licenses
  * Slightly improved licenses description readability
* [12.b] Added `rel` and `about` properties to copyright links.
* [3.03] Removed `&$smarty` in function calls (https://github.com/geekitude/piwigo-plugin-simplecopyright/pull/9), should have been numbered version 12.a to symbolize compatibility with Piwigo v12
* [3.02] Fixed a typo on "which" word.
* [3.01] French translation minor fix.
* [3.00] Added last features I had in mind :
  * enable or not image's page copyright section
  * if plugin can recognize a licence string in image's copyright metadata, it will be turned into a link to that licence's page
  * if image has no copyright in metadata, copyright sectin will switch to a License section showing default licence selected as a link (for admins, it will add an alert icon to suggest to add a copyright)
* [2.04] Switched default to `no_licence` (this should only apply to new installations) and fixed footer's license link's tooltip.
* [2.03] Minor fix because I messed up some Github files.
* [2.01] Added a note on how to correctly present a copyright.
* [2.00] Was confused about copyright and granted license so this version is a first step to clarify this, also added "no-license" setting.
* [1.02] Previous update was a partial mistake, re-enabled conf update function.
* [1.01] Disabled testing functions.
* [1.00] Initial release.
