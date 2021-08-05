<?php

use common\models\News;
use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */
frontend\assets\AboutAsset::register($this);

$this->registerJs('
    $(".card-description").each(function() {
        var text = $(this).html();
        if (text.indexOf("file:", 0) != -1) {
            $(this).text("详见附件");
        }
    });
');

?>

    <div class="container">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            // 'itemView' => '../edite/list',
            'itemView' => '_NewsList',
            'summary' => false,
            'itemOptions' => ['tag' => false],
            'options' => [//针对整个ListView
                'tag' => 'div',
                'class' => 'row typ2-all-folio'
            ],
            'emptyText' => '<div class="alert alert-info" style="margin-top: 20px;">当前栏目不存在新闻</div><div style="width: 100%;height: 250px"></div>',
        ]);
        ?>
    </div>
</div>

<style>
    .container {
        margin-top: 10px;
    }
</style>