<?php

use jackh\admin\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DownloadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="download-index">

<div class="dashboard-header">
    <?php if (Helper::checkRoute("download/delete")) {?>
    <a class="toolbar" multi-choose-mode>
        <i class="fa fa-check-square-o"></i>
    </a>
    <?php } ?>
    <?php if($searchModel->searched) {?>
    <a class="toolbar" action-bk2bsearch="" style="margin-right: 10px">
        <i class="fa fa-chevron-left"></i>
    </a>
    <?php } ?>

    <a class="toolbar" data-toggle="collapse" data-target="#search-collapse">
        <i class="fa fa-search"></i>
    </a>

    <?php if (Helper::checkRoute("download/create")) {?>
    <a class="toolbar pull-right" data-load="#dashboard-content" data-url="download/create">
        <i class="fa fa-plus"></i>
    </a>
    <?php } ?>
</div>
<div class="collapse" id="search-collapse">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
</div>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'summary' => '',
        'itemView' => function ($model, $key, $index, $widget) {
            $widget->itemOptions = array_merge($widget->itemOptions, [
                "data-url"  => Url::toRoute(['update', 'id' => $model->id]),
                "data-delete-url"  => Url::toRoute(['delete', 'id' => $model->id]),
                "data-load" => "#dashboard-content",
            ]);
            $title = Html::tag("p", Html::encode($model->title), ["class" => "title"]);
            return Html::tag("div", $title, ["class" => "content"]);
        },
        'pager'        => [
            'linkOptions' => ["data-load" => "#dashboard-list"],
        ],
        'emptyText'    => '<div class="text-center" style="margin-top: 120px;"><i class="fa fa-bookmark-o" style="font-size: 40px"></i><h3>' . Yii::t('app', 'no result found') . '</h3></div>',
    ]) ?>

</div>
