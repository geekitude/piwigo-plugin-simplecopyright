# piwigo-plugin-simplecopyright

This Piwigo plugin is meant to add a site-wide default license (between base footer and Perso Footer plugin's section) and to show copyright on picture page (between ```author``` and ```creation date fields```) but latest will default to picture's IPTC copyright if it exists. It is possible to choose beetween [Creative Commons](https://creativecommons.org/licenses/) licences (International version 4.0) or any other licence publicly available on internet (through ```Custom copyright``` setting) or no license at all (which means any picture with a correct Copyright is fully protected by Copyright law).

Note that after installation, plugin is set to ```No license``` by default as it seems better to provide higher protection untill user decides otherwise.

[Official page](https://piwigo.org/ext/extension_view.php?eid=839)

# Revisions
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
