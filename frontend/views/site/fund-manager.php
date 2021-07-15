<?php

use frontend\components\Paragraph;
use yii\widgets\ListView;
use yii\helpers\Html;

frontend\assets\AboutAsset::register($this);

?>
<div class="us-title">
    <h2>走进友山</h2>
    <p>基金经理</p>
</div>
<div class="media fund-manager">
    <?= ListView::widget([
            'dataProvider' => $model,
            'itemView' => 'fund-manager-block',
            'summary' => false,
            'emptyText' => '<div class="alert alert-info" style="margin-top: 20px;">暂时没有可以显示的基金经理</div><div style="width: 100%;height: 250px"></div>',
        ]);
    ?>
</div>

