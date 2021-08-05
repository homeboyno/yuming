<?php

frontend\assets\AboutAsset::register($this);

$sidebarParams = include Yii::$app->basePath . '/views/layouts/Sidebar.php';
?>

<!-- <div class="container">
    <div class="col-xs-12 col-md-10 sidebar-right">
        <div class="us-title">
            <h2></h2>
            <p></p>
        </div>
        <div>
            <iframe class="edite" onload="this.height=this.contentWindow.document.body.scrollHeight" src="/edite/view?type=edite&id=1"></iframe> -->
            <!-- <div>123</div>
        </div>
    </div>
</div> -->

<div class="papri-about-typ1-area bgc-2 mt-100 mb-100 pt-120 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-lg-12">
                <div class="section-title-style-3 lite">
                    <h4>about</h4>
                    <span></span>
                    <p>您的满意就是我们的使命</p>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <!-- <div class="about-typ1-middle-content-wrape"> -->
                    <di v class="edite"></div>
                    <!-- <iframe class="edite" onload="this.height=this.contentWindow.document.body.scrollHeight" src="/edite/view?type=edite&id=1"></iframe> -->
                    <!-- <p>There are many variations of passages of Lorem Ipsum but the majority have suffered alteration in some form, injected , or randomised words which don't look even believable. If you are going to use a passage of Lorem</p> -->
                    <!-- <div class="middle-content-counter-wrape mt-45">
                        <div class="single-about-counter">
                            <h2><span class="counter">50</span> +</h2>
                            <h4>years of experience</h4>
                        </div>
                        <div class="single-about-counter">
                            <h2><span class="counter">10</span> +</h2>
                            <h4>best design awards</h4>
                        </div>
                    </div>
                </div> -->
            <!-- </div> -->
            <!-- <div class="col-xl-3 col-lg-4">
                <div class="papri-subscribe-typ3-wraper">
                    <h2>news letter</h2>
                    <form action="#" class="subscribe-typ3-form">
                        <input class="form-control" type="email" placeholder="Type Your Email">
                        <button type="submit" class="btn btn-typ7">sign up</button>
                    </form>
                </div>
            </div> -->
        </div>
    </div>
 </div>


<style>
    
</style>

<script type="text/javascript">
    // $(document).ready(function() {
        
    // });

    window.onload = function() {
        $(".edite").load("/edite/view?type=edite&id=1");
    }
</script>