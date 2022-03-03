# Smash Ultimate Tools

This is a re-write of the original [Smash Ultimate Tools](https://github.com/Coolsonickirby/smashultimatewebtools) which used to use Laravel as a framework. This re-write gets rid of Laravel and doesn't use databases to store stuff. This also makes the code look much cleaner compared to the old one.

## Changes

- Audio
  - Stopped using python scripts to get Audio Information (switched over to using SoX completely)
  - Added YouTube Link option (only if allowed in `config.php` & `ffmpeg` is downloaded and added to PATH)
  - Added PyMusicLooper option (only if allowed in `config.php` and `pymusiclooper` is installed (with the `--stdout` option)
  - Added support for VGMStream Conversion instead of only BRSTMS
  - Added new conversion option: wav
  - Removed `Convert Song to Compatible wav` & `Convert vgmstream compatible formats to wav` pages
  - Removed old style editor for the `Replace nus3audio sound banks with idsps` page
- CSS Editor
  - No Changes
- SSS Editor
  - No Changes
- Fighter Param Editor
  - No Changes
- MSBTEditor
  - No Changes
- Minecraft Java Skin Converter
  - Removed
- Common Color Editor
  - Added

## Credits

### Main

- <a href="./">This Website</a> - <a href="https://github.com/coolsonickirby/">Coolsonickirby/Random</a>
- <a href="https://www.youtube.com/watch?v=pAtd6NBvVA0">Major help with the redesign for the 1
  year anniversary</a> - <a href="https://www.youtube.com/watch?v=pAtd6NBvVA0">Pizza 3.14</a>
- <a href="https://fontmeme.com/fonts/super-smash-font/">Smash Font</a> - Pokemon-Diamond

### Audio

- <a href="https://github.com/Thealexbarney/VGAudio">VGAudio</a> - <a href="https://github.com/Thealexbarney/">Thealexbarney</a>
- <a href="https://github.com/jam1garner/nus3audio-rs">nus3audio</a> - <a href="https://github.com/jam1garner/">jam1garner</a>
- <a href="http://sox.sourceforge.net/">SoX</a> - <a href="https://sourceforge.net/u/cbagwell/">cbagwell</a>, <a href="https://sourceforge.net/u/mansr/profile/">mansr</a>, <a href="https://sourceforge.net/u/robs/profile/">robs</a>,
  <a href="https://sourceforge.net/u/uklauer/profile/">
  uklauer
  </a>
- <a href="https://cdn.discordapp.com/attachments/516449848057135124/653439158144073729/nus3audio.bat">Batch
  Scripts used for reference</a> - <a href="https://github.com/thatnintendonerd/">ThatNintendoNerd</a>
- <a href="https://docs.google.com/document/d/13nnPPQK46HE1c30LlcVj8Nrfdxjx1t1vH0cWMJqaSVA/">Song
  names and
  file names (Victory themes missing from the document file for some reason)</a> - <a href="https://gamebanana.com/members/1507074">PlayerRager</a>, <a href="https://www.youtube.com/channel/UCaMTWkuqc_W1D5CIPN7DEiw">Spook Rake</a>,
  <a href="https://gamebanana.com/members/1537331">zrksyd</a>
- <a href="https://docs.google.com/document/d/1MSzUOeCxIyCpBRZBuko2wXg84exVt8VM9be0i7eAOcE/edit?usp=sharing">Fire
  Emblem Three Houses Songs</a> - <a href="https://gamebanana.com/members/1480709">VGIII
  <3</a>, <a href="https://gamebanana.com/members/1707207">A Mudkip</a>
- <a href="https://docs.google.com/spreadsheets/d/1LD9qmlV_MxJ8Lm-Dxi3QmH_ZU1LBXHpKFHRuPycmkfw/edit#gid=0">ARMS
  Songs</a> - <a href="https://gamebanana.com/members/1513589">Mowjoh</a>
- <a href="https://cdn.discordapp.com/attachments/516449848057135124/662099184584753152/smashAudio.zip">Python
  script
  to convert audio (Used as refrence for getting the sample rate)</a> -
  <a href="https://github.com/Genwald">Genwald</a>
- Teaching me how to convert samples between sample rates - <a href="https://gamebanana.com/members/1480857">JoeTE</a>
- <a href="https://github.com/yt-dlp/yt-dlp">yt-dlp for downloading and converting YouTube Videos</a> - <a href="https://github.com/yt-dlp"> yt-dlp org</a>
- <a href="https://github.com/FFmpeg/FFmpeg">FFmpeg</a> - <a href="https://github.com/FFmpeg">FFmpeg Org</a>
- <a href="https://github.com/arkrow/PyMusicLooper">PyMusicLooper (for automatically finding loop points)</a> - <a href="https://github.com/arkrow/">Hazem Nabil/arkrow</a>

### MSBT

- <a href="https://github.com/exelix11/3DLandMSBTeditor">MSBT Original Source Code</a> - <a href="https://github.com/exelix11/">exelix11</a>
- <a href="https://github.com/IcySon55/3DLandMSBTeditor">MSBT Improved Source Code</a> - <a href="https://github.com/IcySon55/">IcySon55</a>
- <a href="https://github.com/Coolsonickirby/MSBTEditorCli">MSBTEditorCli</a> - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>
- MSBTEditor Web Interface - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>

### CSS Editor

- <a href="https://github.com/BenHall-7/paracobNET">ParamXML</a> - <a href="https://github.com/BenHall-7">Ben Hall</a>
- <a href="https://github.com/lukasoppermann/html5sortable">html5sortable</a> - <a href="https://github.com/lukasoppermann">Lukas Oppermann</a>
- Helping me figure out how to sync animate child elements background (Unfortunatly not used because
  of preformance issues) - <a href="https://github.com/jam1garner/">jam1garner</a>
- CSS Editor Web Interface - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>

### SSS Editor

- <a href="https://github.com/BenHall-7/paracobNET">ParamXML</a> - <a href="https://github.com/BenHall-7">Ben Hall</a>
- <a href="https://github.com/lukasoppermann/html5sortable">html5sortable</a> - <a href="https://github.com/lukasoppermann">Lukas Oppermann</a>
- <a href="http://www.dhtmlgoodies.com/scripts/form_widget_editable_select/form_widget_editable_select.html">Editable Input Select</a> - <a href="http://www.dhtmlgoodies.com/">Alf Magne Kalleland</a>
- Helping me get some stage icons and big images - <a href="https://gamebanana.com/members/1537331">zrksyd</a> & <a href="https://gamebanana.com/members/1707207">A Mudkip</a>
- Stage Editor Web Interface - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>

### Fighter Param Editor

- <a href="https://github.com/BenHall-7/paracobNET">ParamXML</a> - <a href="https://github.com/BenHall-7">Ben Hall</a>
- Fighter Param Editor Web Interface - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>

### Minecraft Java Skin Converter

- <a href="https://github.com/jam1garner/img2nutexb">img2nutexb</a> - <a href="https://github.com/jam1garner">jam1garner</a>
- Minecraft Java Skin Converter Web Interface - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>

### Common Color Editor

- <a href="https://github.com/BenHall-7/paracobNET">ParamXML</a> - <a href="https://github.com/BenHall-7">Ben Hall</a>
- Common Color Editor Web Interface - <a href="https://github.com/Coolsonickirby/">Coolsonickirby/Random</a>

### Special Thanks

- Getting me the updated files - <a href="https://twitter.com/BruhLookAtThis">BruhLookAtThis</a>, <a href="https://www.youtube.com/channel/UCm4vgCpCYLHkGwldLPNpSQw">AGhostsPumpkinSoup</a>, æostal568, <a href="https://twitter.com/Demonslayerx8">DemonSlayerx8</a>, <a href="https://twitter.com/Lizar_Doug">Nin10Doug</a>, <a href="https://twitter.com/Rman4100">Rman41</a>,
  <a href="https://www.reddit.com/user/getsome2198">flamecrest920</a>
