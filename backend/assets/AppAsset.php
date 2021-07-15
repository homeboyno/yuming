<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'/styles/material-kit.css'
	];
	public $js = [
	];
	public $depends = [
		'yii\bootstrap\BootstrapAsset',
	];
}
