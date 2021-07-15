<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WorkbenchAsset extends AssetBundle {
	public $sourcePath = '@frontend/assets';
	public $css = [
		// '//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css',
		// '//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css',
		'//cdn.bootcss.com/quill/0.20.0/quill.snow.min.css',

		'styles/lib/bootstrap.min.css',
		'styles/lib/font-awesome.min.css',
		// 'styles/lib/quill.snow.min.css',

		'styles/workbench.css',
	];
	public $js = [
		// '//cdn.bootcss.com/angular.js/1.4.7/angular.min.js',
		'//cdn.bootcss.com/quill/0.20.0/quill.min.js',
		// '//cdn.bootcss.com/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js',
		// '//cdn.bootcss.com/angular-ui-router/0.2.15/angular-ui-router.min.js',
		// '//cdn.bootcss.com/angular-file-upload/1.1.6/angular-file-upload.min.js',

		'scripts/lib/angular.min.js',
		// 'scripts/lib/quill.min.js',
		'scripts/lib/ui-bootstrap-tpls.min.js',
		'scripts/lib/angular-ui-router.min.js',
		'scripts/lib/angular-file-upload.min.js',

		'scripts/lib/fcsaNumber.min.js',

		'scripts/share/util.js',
		'scripts/share/md5.js',
		'scripts/workbench/WorkBench.Module.js',
	];
}
