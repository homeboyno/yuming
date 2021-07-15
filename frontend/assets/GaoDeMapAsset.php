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
class GaoDeMapAsset extends AssetBundle {
	// public $sourcePath = '@webroot/assets';

	public $js = [
		'http://webapi.amap.com/maps?v=1.3&key=55c68b3b41dc9c6fb32355c852441986',
		'http://cache.amap.com/lbs/static/addToolbar.js',
	];
}
