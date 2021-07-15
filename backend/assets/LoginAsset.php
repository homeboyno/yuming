<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'/styles/lib/material-kit.css',
		'//cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css',
		'//cdn.bootcss.com/animate.css/3.5.2/animate.min.css'
	];
	public $js = [
    	'/scripts/lib/material.min.js',
    	'/scripts/lib/material-kit.js'
	];
	public $depends = [
    'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];
}
