<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CompanyImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="company-image-index">
    <div class="col-sm-12" style="margin-top: 40px;">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">image</i>
            </div>
            <div class="card-title"><h4>职场风貌</h4></div>
            <div class="card-content">
                <div class="row col-sm-12">
                    <button class="btn btn-info btn-round btn-just-icon pull-right"
                            data-load="#dashboard-modal"
                            data-url="<?=Url::to(["/company-image/create", "cid" => $cid]);?>"
                            data-content="添加" data-toggle="popover">
                        <i class="material-icons">add</i>
                    </button>
                </div>
                <?php Pjax::begin([
                    'id' => 'CompanyImageContainer',
                    'options' => [
                        'data-reload-url' => Url::to(["/company-image/index", "cid" => $cid])
                    ]
                ]); ?>
                <?=ListView::widget([
                	'summary' => '',
                	'emptyText' => "暂时没有纪录",
                	'dataProvider' => $dataProvider,
                    'options' => ["class" => "col-xs-12 row", "style" => "margin: 20px 0"],
                	'itemView' => function ($model, $key, $index, $widget) {
                        $delete_url = Url::to(["/company-image/delete", "id" => $model->id]);
                        $delete = Html::tag('i', 'delete', [
                            'class' => 'material-icons',
                			'pjax-delete' => 'union-image',
                			'data-url' => $delete_url,
                		]);

                        $update_url = Url::to(["/company-image/update", "id" => $model->id]);
                        $update = Html::tag('i', 'border_color', [
                            'class' => 'material-icons',
                			"data-load" => '#dashboard-modal',
                			'data-url' => $update_url,
                		]);
                		$handler = Html::tag("div", $delete . $update, ["class" => "handler"]);
                		return Html::tag("div", $handler, ["style" => "background-image: url('" . $model->url . "')", "class" => "dashboard-image-handler"]);
                	},
                ]);?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
