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
class ProductAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		'styles/product.css',
	];
	public $js = [
		'//cdn.bootcss.com/Chart.js/1.1.1/Chart.min.js',
		'//cdn.bootcss.com/moment.js/2.10.6/moment.min.js',
		'//cdn.bootcss.com/waypoints/4.0.0/jquery.waypoints.min.js',
		'scripts/product.js',
	];
	public $depends = ['frontend\assets\CommonAsset', 'jackh\aurora\assets\bundles\QuillAsset'];
}
