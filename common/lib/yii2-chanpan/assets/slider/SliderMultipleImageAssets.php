<?php

namespace cpn\chanpan\assets\slider;

use yii\web\AssetBundle;

class SliderMultipleImageAssets extends AssetBundle {

	public $sourcePath = '@cpn/chanpan/assets/slider';
	public $css = [
            'css/owl.carousel.min.css',
            'css/owl.theme.default.css'
	];
	public $js = [
		'owl.carousel.min.js',
	];
	public $depends = [
//             'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
	];

}
