<?php

use yii\web\View;

frontend\assets\AboutAsset::register($this);
?>

<div class="us-title">
    <h2>走进友山</h2>
    <?php if (strpos(Yii::$app->request->url, 'party') != false): ?>
        <p>党建工作</p>
    <?php else: ?>
        <p>公会风采</p>
    <?php endif;?>
</div>

<div class="us-title">
    <h2>组织介绍</h2>
</div>

<div class="us-content">
    <div>
        <?=$content?>
    </div>
</div>

<div class="us-title">
    <h2>组织活动</h2>
</div>

    <div class='party-photos-container'>
        <div id="myCarousel" class="carousel slide" style="margin:0 auto; width:100%">
        <!-- 轮播（Carousel）指标 -->
        <ol class="carousel-indicators" style="width: 100%;margin-left: -50%;">
            <?php 
                foreach ($images as $key => $image) {
                    if ($key == 0) echo '<li data-target="#myCarousel" data-slide-to="'.$key.'" class="active"></li>';
                    else echo '<li data-target="#myCarousel" data-slide-to="'.$key.'"></li>';
                }
            ?>
        </ol>   
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
        <?php
            foreach ($images as $key => $image) {
                if ($key == 0) {
                    echo '
                    <div class="item active">
                        <img src="'. $image["url"] .'" style="width:100%">
                        <div class="carousel-caption"></div>
                        <figcaption>' . $image["info"] . '</figcaption>
                    </div>';
                }else {
                    echo '
                    <div class="item">
                        <img src="'. $image["url"] .'">
                        <figcaption>' . $image["info"] . '</figcaption>
                    </div>';
                }
            }
        ?>
        </div>  
        <!-- 轮播（Carousel）导航 -->
        <a class="left carousel-control" style="left:0" href="javascript:prev()" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="javascript:next()" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<?php
$this->registerJs("
$(function() {
    $('.pop').on('click', function() {
        $('.img-party-modal').attr('src', $(this).find('img').attr('src'));
        $('.caption-party-modal').html($(this).find('figcaption').html());
        $('#imagemodal').modal('show');
    });
});

function prev() {
    $('#myCarousel').carousel('prev');
}

function next(){
    $('#myCarousel').carousel('next');
}
$(document).ready(function(){
    $('#myCarousel').carousel({interval: 3000});
})
    
", View::POS_END);
?>

<style type="text/css">
.party-photos-container {
    width: 100%;
    margin-top:15px;
}
.party-photo {
    height: 130px;
    padding-right: 10px;
    overflow: hidden;
    margin-bottom: 3em;
}
.img-party-photo {
    width: 100%;
    height: 110px;
}
.carousel-inner figcaption {
    width: 100%;
    text-align: center;
    height: 1.2em;
    line-height: 1.2em;
    margin-bottom: 10px;
}
/* 本地覆盖了 us-content 的几个样式 */
.us-content p {
    line-height: 1.5em;
}
@media(max-width: 768px) {
    .party-photos-container {
        display: block;
    }
    .party-photo {
        display: block;
        height: auto;
        overflow: hidden;
    }
    .img-party-photo {
        width: 100%;
        height: auto;
    }
    .party-building {
        margin-left: auto;
        margin-right: auto;
    }
    .party-photos-container {
        display: block;
    }
    .party-photo {
        display: block;
    }
}
</style>