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
class IEAsset extends AssetBundle {
	public $basePath = '@webroot';

	public $jsOptions = ['condition' => 'lt IE 9', 'position' => \yii\web\View::POS_HEAD];

	public $js = [
		'//cdn.bootcss.com/html5shiv/r29/html5.min.js',
		// '//cdn.bootcss.com/respond.js/1.4.2/respond.min.js',
		// 'scripts/lib/html5.min.js',
		'scripts/lib/respond.min.js',
		'scripts/lib/excanvas.js',
	];
}
