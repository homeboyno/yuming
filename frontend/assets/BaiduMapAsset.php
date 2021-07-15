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
class BaiduMapAsset extends AssetBundle {
	// public $sourcePath = '@webroot/assets';

	public $js = [
		'http://api.map.baidu.com/api?v=2.0&ak=hfEMPGg5K4dNDcFfKXAc2u1h9CYI2Pi9',
	];
}
