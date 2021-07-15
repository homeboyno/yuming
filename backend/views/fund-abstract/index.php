<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\FundAbstractSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="fund-abstract-index">


<div class="col-sm-12">
    <div class="row col-sm-12">
        <button class="btn btn-info btn-round btn-just-icon pull-right"
                data-load="#dashboard-modal"
                data-url="<?=Url::toRoute(["/fund-abstract/create", "fund_id" => $fund_id]);?>"
                data-content="添加" data-toggle="popover">
            <i class="material-icons">add</i>
        </button>
    </div>
    <?php Pjax::begin([
        "id" => "FundAbstractContainer",
        'options' => [
            'data-reload-url' => Url::to(["fund-abstract/index", "fund_id" => $fund_id])
        ]
    ]);?>
    <?=GridView::widget([
    	'dataProvider' => $dataProvider,
    	'summary' => false,
        'tableOptions' => ["class" => "table text-left"],
    	'emptyText' => "暂时没有纪录",
    	'columns' => [
    		[
    			'label' => '类型',
    			'value' => function ($data) { return $data->type; },
    		],
    		[
    			'label' => '详细',
    			'value' => function ($data) { return $data->info; },
    		],
            [
                'class' => 'jackh\material\ActionColumn',
                'visibleButtons' => ["view" => false],
                'specialOptions' => [
                    'delete' => ['pjax-delete' => ""],
                    'update' => ['data-load' => "#dashboard-modal"],
                ],
                'urlCreator' => function($action, $model, $key, $index) {
                    $params = is_array($key) ? $key : ['id' => (string) $key];
                    $params[0] = 'fund-abstract/' . $action;
                    return Url::toRoute($params);
                }
            ],
    	],
    ]);?>
    <?php Pjax::end();?>
    </div>
</div>
