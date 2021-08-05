<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AboutAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		'styles/about.css',
	];
	public $js = [
		'//cdn.bootcss.com/waypoints/3.1.1/jquery.waypoints.min.js',
		'scripts/about/about.js'
	];
	public $depends = [
		'frontend\assets\CommonAsset', 
		'jackh\aurora\assets\bundles\QuillAsset'
	];
}
