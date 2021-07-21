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
class MainAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'/styles/css/bootstrap.min.css',
        '/styles/css/font-awesome.min.css',
        '/styles/css/themify-icons.css',
        '/styles/css/elegant-icons.css', 
        '/styles/css/flaticon-set.css', 
        '/styles/css/magnific-popup.css', 
        '/styles/css/owl.carousel.min.css', 
        '/styles/css/owl.theme.default.min.css', 
        '/styles/css/animate.css', 
        '/styles/css/bootsnav.css',
        '/styles/css/style.css', 
        '/styles/css/responsive.css',
        '/styles/css/scrolltop.css',

        // icons
		'//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.css',
		'//cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css',

		// basic lib
		'//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css',
		'//cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.css',
		'/styles/lib/material-kit.css',

		'//cdn.bootcss.com/font-awesome/4.4.0/css/font-awesome.min.css',
		'//cdn.bootcss.com/animate.css/3.5.1/animate.min.css'

	];
	public $js = [
		'/scripts/js/jquery-1.12.4.min.js',
        '/scripts/js/popper.min.js',
        '/scripts/js/bootstrap.min.js',
        '/scripts/js/jquery.appear.js',
        '/scripts/js/jquery.easing.min.js',
        '/scripts/js/jquery.magnific-popup.min.js',
        '/scripts/js/modernizr.custom.13711.js',
        '/scripts/js/owl.carousel.min.js',
        '/scripts/js/wow.min.js',
        '/scripts/js/progress-bar.min.js',
        '/scripts/js/isotope.pkgd.min.js',
        '/scripts/js/imagesloaded.pkgd.min.js',
        '/scripts/js/count-to.js',
        '/scripts/js/ytplayer.min.js',
        '/scripts/js/bootsnav.js',
        '/scripts/js/main.js',
        '/scripts/js/scrolltop.js',


        '//cdn.bootcss.com/modernizr/2.8.3/modernizr.min.js',
		'//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js',
		'//cdn.bootcss.com/bootstrap-sweetalert/1.0.1/sweetalert.min.js',
		'/scripts/lib/material.min.js',



	];
	public $depends = [
        'frontend\assets\IEAsset',
		'yii\web\JqueryAsset'
    ];
}
