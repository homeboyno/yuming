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
class SharedAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		// icons
		'//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css',
		'//cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css',

		// basic lib
		'//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css',
		'/styles/lib/material-kit.css',

		'//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css',
		'//cdn.bootcss.com/animate.css/3.5.1/animate.min.css',

		'styles/styles.css',
	];

	public $js = [
		'//cdn.bootcss.com/modernizr/2.8.3/modernizr.min.js',
		'//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js',
		'/styles/lib/material-kit.js',

		'scripts/share/md5.js',
		'scripts/share/base.js',
	];

	public $depends = [
		'frontend\assets\IEAsset',
		'yii\web\JqueryAsset'
	];
}
