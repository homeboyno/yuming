<?php

// frontend\assets\SiteAsset::register($this);
use \yii\helpers\Html;
?>

<div class="banner-area text-capitalized bg-bottom text-light text-default" style="background-image: url(/images/wget/11.png);">
    <div class="container">
        <div class="double-items">
            <div class="row align-center">

                <div class="col-lg-6 info">
                    <h2 class="wow fadeInRight" data-wow-defaul="300ms">We're building software<strong>to manage business</strong></h2>
                    <p class="wow fadeInLeft" data-wow-delay="500ms">
                        Lasted hunted enough an up seeing in lively letter. Had judgment out opinions property the supplied.
                    </p>
                    <a class="btn btn-md btn-light effect wow fadeInUp" data-wow-delay="700ms" href="#">Get Started <i class="fas fa-angle-right"></i></a>
                </div>

                <div class="col-lg-5 offset-lg-1 thumb wow fadeInRight" data-wow-delay="900ms">
                    <img src="/images/picture/11.png" alt="Thumb">
                </div>
                
            </div>
        </div>
    </div>
</div>
<button class="material-scrolltop" type="button"></button>
<div class="material-scrolltop"></div>

<style>
    .banner-area.bg-bottom 
    {
        background-size: cover;
        background-position: bottom center;
    },
    .banner-area {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .double-items > .row div {
        height: auto;
    }
</style>
