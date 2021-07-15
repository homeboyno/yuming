<?php

use yii\web\View;
use yii\widgets\ListView;
frontend\assets\AboutAsset::register($this);
?>

<div class="us-title">
    <h2>走进友山</h2>
    <p>企业荣誉</p>
</div>

<div class="edite-list">
<?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '../edite/list',
        'summary' => false,
        'itemOptions' => ['tag' => false],
        'options' => false,
        'emptyText' => '<div class="alert alert-info" style="margin-top: 20px;">当前栏目不存在新闻</div><div style="width: 100%;height: 250px"></div>',
        'layout' => "{summary}\n{items}\n<div class='row'>{pager}</div>"
    ]);
?>
</div>
