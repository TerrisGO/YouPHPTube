<?php

require_once $global['systemRootPath'] . 'plugin/Plugin.abstract.php';

class AD_Overlay extends PluginAbstract {

    public function getDescription() {
        $txt = "Display simple overlays - similar to YouTube's \"Annotations\" feature in appearance - during video playback.";
        $help = "";
        return $txt . $help;
    }

    public function getName() {
        return "AD_Overlay";
    }

    public function getUUID() {
        return "ADO73225-3807-4167-ba81-0509dd280e06";
    }

    public function getPluginVersion() {
        return "1.0";
    }

    public function getEmptyDataObject() {
        global $global;
        $obj = new stdClass();

        $o = new stdClass();
        $o->type = "textarea";
        $o->value = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- YouPHPTube Videos -->
<ins class="adsbygoogle"
     style="display:inline-block;width:468px;height:60px"
     data-ad-client="ca-pub-8404441263723333"
     data-ad-slot="6092946505"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
';
        $obj->adText = $o;

        //$obj->allowUsersToAddCustomText = false;
        //Where to display overlays, by default. Assuming the included stylesheet is used, the following values are supported:
        // "top-left", "top", "top-right", "right", "bottom-right", "bottom", "bottom-left", "left".
        $obj->align = "bottom-left";
        $obj->showBackground = true;
        //bottom aligned overlays will adjust positioning when the control bar minimizes.
        $obj->attachToControlBar = false;
        /*
          $obj->start = true;
          $obj->mid25Percent = false;
          $obj->mid50Percent = false;
          $obj->mid75Percent = false;
          $obj->end = false;

          $obj->durationInSeconds = 30;
         * 
         */
        $obj->debug = false;

        return $obj;
    }

    public function getTags() {
        return array('free');
    }

    public function getHeadCode() {
        $obj = $this->getDataObject();
        global $global;
        $css = '<link href="' . $global['webSiteRootURL'] . 'plugin/AD_Overlay/videojs-overlay/videojs-overlay.css" rel="stylesheet" type="text/css"/>';

        $css .= '<style>.video-js .vjs-overlay-background, .video-js .vjs-overlay-no-background {

    max-width: 100%;
    width: 100%;
    margin-left:-5px;

}</style>';
        return $css;
    }

    public function getFooterCode() {
        $obj = $this->getDataObject();
        global $global;

        $js = '<div id="adOverlay" style="display:none;"><button class="pull-right btn" onclick="$(\'.vjs-overlay\').fadeOut();"><i class="fa fa-times"></i></button>'
                . '<center>' . $obj->adText->value . '</center>'
                . '</div>';

        $js .= '<script src="' . $global['webSiteRootURL'] . 'plugin/AD_Overlay/videojs-overlay/videojs-overlay.js" type="text/javascript"></script>';

        $js .= '<script>'
                . "$(document).ready(function () {     if (typeof player == 'undefined') {
                    player = videojs('mainVideo');
                };
                player.overlay({
        content: $('#adOverlay').html(),
        debug: true,
        showBackground:" . ($obj->showBackground ? "true" : "false") . ",
        attachToControlBar:" . ($obj->attachToControlBar ? "true" : "false") . ",
        overlays: [{
          start: 'play',
          end: 3600,
          align: '{$obj->align}'
        }]
      });});"
                . '</script>';
        return $js;
    }

}
