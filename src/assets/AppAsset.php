<?php

namespace assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $css = [
        "css/bootstrap.min.css",
        "font-awesome/css/font-awesome.css",
        "css/animate.css",
        "js/plugins/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css",
        "css/plugins/chosen/bootstrap-chosen.css",
        "css/plugins/datapicker/datepicker3.css",
        "css/clean-switch.css",
        "js/cropperjs/dist/cropper.min.css",
        "css/style.css",
    ];
    public $js = [
        "js/bootstrap.min.js",
        "js/plugins/metisMenu/jquery.metisMenu.js",
        "js/plugins/slimscroll/jquery.slimscroll.min.js",
        "js/plugins/flot/jquery.flot.js",
        "js/plugins/flot/jquery.flot.tooltip.min.js",
        "js/plugins/flot/jquery.flot.spline.js",
        "js/plugins/flot/jquery.flot.resize.js",
        "js/plugins/flot/jquery.flot.pie.js",
        "js/plugins/flot/jquery.flot.symbol.js",
        "js/plugins/flot/jquery.flot.time.js",
        "js/plugins/pace/pace.min.js",
        "js/plugins/chosen/chosen.jquery.js",
        "js/plugins/sparkline/jquery.sparkline.min.js",
        "js/plugins/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js",
        "js/plugins/datapicker/bootstrap-datepicker.js",
        "js/blueimp-uploader/js/vendor/jquery.ui.widget.js",
        "js/blueimp-uploader/js/jquery.fileupload.js",
        "js/cropperjs/dist/cropper.min.js",
        "js/inspinia.js",
        "js/jquery-ui-1.10.4.min.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}