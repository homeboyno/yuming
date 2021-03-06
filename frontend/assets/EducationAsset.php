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
class EducationAsset extends AssetBundle {
	public $sourcePath = '@jackh/dashboard/assets';
	public $baseUrl = '@web';
	public $css = [
        // icons
		'//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css',
        '//cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css',

        // basic lib
        '/styles/lib/material-kit.css',

		'//cdn.bootcss.com/chartist/0.10.1/chartist.min.css',
		'//cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.css',
		'//cdn.bootcss.com/summernote/0.8.2/summernote.css',
	];
	public $js = [
		'/scripts/lib/material.min.js',
		'/scripts/lib/bootstrap-notify.js',
		'//cdn.bootcss.com/chartist/0.10.1/chartist.min.js',
		'//cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.js',
        '//cdn.bootcss.com/jquery-parallax/1.1.3/jquery-parallax-min.js'
	];
	public $depends = [
		'yii\bootstrap\BootstrapPluginAsset',
	];
}
