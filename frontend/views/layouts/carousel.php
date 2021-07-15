<?php
use yii\web\View;

$this->registerJs("
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

<div id="myCarousel" class="carousel slide" style="margin:15px auto 0; width:80%">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
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