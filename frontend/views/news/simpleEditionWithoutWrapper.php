<?php

frontend\assets\AboutAsset::register($this);
?>
<?php include Yii::$app->basePath . '/views/site/inner-banner.php';?>

<div class="container">
    <div class="col-xs-0 col-md-2">
        <?php include 'sidebar.php';?>
    </div>
    <div class="col-xs-12 col-md-10">
        <div class="us-title">
            <h2>走进友山</h2>
            <p><?=$name?></p>
        </div>
        <div>
            <?=$content?>
        </div>
    </div>
</div>
