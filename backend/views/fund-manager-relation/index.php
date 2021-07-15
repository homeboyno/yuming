<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FundManagerRelationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="fund-manager-relation-index">
    <div class="col-sm-12">
        <div class="row col-sm-12">
            <button class="btn btn-info btn-round btn-just-icon pull-right" data-load="#dashboard-modal"
                    data-url="<?=Url::toRoute(["/fund-manager-relation/update", "fid" => $fid]);?>"
                    data-content="编辑" data-toggle="popover">
                <i class="material-icons">build</i>
            </button>
        </div>

        <?php Pjax::begin([
        	'id' => 'FMRContainer',
            'options' => [
                'data-reload-url' => Url::to(["fund-manager-relation/index", "fid" => $fid])
            ]
        ]);?>
            <?=ListView::widget([
            	'dataProvider' => $dataProvider,
            	'summary' => '',
            	'itemView' => function ($model, $key, $index, $widget) {
            		$avatar = Html::tag('img', '', ["src" => $model->fundManager["portrait"] ? $model->fundManager["portrait"] : '/images/fallback-avatar.jpg', "class" => "img-rounded img-responsive img-raised"]);
            		$name = Html::tag('p', $model->fundManager["name"], ["style" => "margin-top: 1em"]);
            		return Html::tag("div", $avatar . $name, ["class" => "col-sm-3 text-center", "style" => "margin-top: 14px;"]);
            	},
            	'emptyText' => Yii::t('app', 'no result found'),
            ])?>
        <?php Pjax::end();?>

    </div>
</div>
