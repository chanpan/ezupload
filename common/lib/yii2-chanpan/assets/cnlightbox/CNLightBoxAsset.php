<?php

 
namespace cpn\chanpan\assets\cnlightbox;
 
class CNLightBoxAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/cnlightbox/assets';
    public $css = [
        'css/lightgallery.css'
    ];
    public $js = [
        'js/lightgallery-all.js'         
    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
