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
class EditeAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $depends = ['frontend\assets\CommonAsset', 'jackh\aurora\assets\bundles\QuillAsset'];
}
