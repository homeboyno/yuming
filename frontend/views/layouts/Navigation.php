<?php
use app\models\User;
use common\models\Company;
use common\models\Edite;
use common\models\Education;
use common\models\Fund;
use common\models\News;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

// $user = Yii::$app->user->identity;
// $isGuest = (gettype($user) != 'object') || $user->type == 3; // 没取到model即未登录

?>


<!-- Preloader Start -->
    <div class="se-pre-con"></div>
    <!-- Preloader Ends -->

    <!-- Header 
    ============================================= -->
    <header id="home">

        <!-- Start Navigation -->
        <nav class="navbar navbar-default attr-bg navbar-fixed white no-background bootsnav">

            <div class="container">

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="index.html">
                        <img src="/images/logo-light.png" class="logo logo-display" alt="Logo">
                        <img src="/images/picture/logo.png" class="logo logo-scrolled" alt="Logo">
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                        <li class="dropdown active dropdown-right">
                            <a href="#home" class="dropdown-toggle smooth-menu active" data-toggle="dropdown" >Home</a>
                            <ul class="dropdown-menu">
                                <li><a href="index.html">Home Version One</a></li>
                                <li><a href="index-2.html">Home Version Two</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#about">About</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#features">Features</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#overview">Overview</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#team">Team</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#pricing">Pricing</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#blog">Blog</a>
                        </li>
                        <li>
                            <a class="smooth-menu" href="#contact">Contact</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
        <!-- End Navigation -->

    </header>
    <!-- End Header -->
