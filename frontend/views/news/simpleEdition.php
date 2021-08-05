<?php

frontend\assets\AboutAsset::register($this);
?>
<div class="container">
    <div class="col-xs-0 col-md-2">
        <?php include 'sidebar.php';?>
    </div>
    <div class="col-xs-12 col-md-10">
        <div class="us-title">
            <h2>走进友山</h2>
            <p><?=$name?></p>
        </div>
        <div style="margin-top: -20px">
            <?=$content?>
        </div>
    </div>
</div>
