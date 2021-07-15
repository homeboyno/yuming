<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\FundValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="fund-value-index">

<div class="col-sm-12">
    <div class="row col-sm-12">
        <button class="btn btn-info btn-round btn-just-icon pull-right"
                data-load="#dashboard-modal"
                data-url="<?=Url::toRoute(["/fund-value/create", "fid" => $fid]);?>"
                data-content="添加" data-toggle="popover">
            <i class="material-icons">add</i>
        </button>
        <button class="btn btn-warning btn-round btn-just-icon pull-right" style="margin-right: 1em"
                data-load="#dashboard-modal"
                data-url="<?=Url::toRoute(["/fund-value/import", "id" => $fid]);?>"
                data-content="导入" data-toggle="popover">
            <i class="material-icons">swap_vert</i>
        </button>
        <button class="btn btn-danger btn-round btn-just-icon pull-right" style="margin-right: 1em"
                pjax-multiple-delete="#fund-value-grid"
                data-content="删除" data-toggle="popover">
            <i class="material-icons">delete</i>
        </button>
    </div>
    <div class="table-responsive col-xs-12">
        <?php Pjax::begin([
            'id' => 'FundValueContainer',
            'options' => [
                'data-reload-url' => Url::to(["fund-value/index", "fid" => $fid])
            ]
        ]);?>
        <?=GridView::widget([
        	'dataProvider' => $dataProvider,
        	'id' => 'fund-value-grid',
            'tableOptions' => ["class" => "table text-left"],
        	'summary' => false,
        	'emptyText' => "暂时没有净值纪录",
        	'columns' => [
        		['class' => 'jackh\dashboard\CheckboxColumn'],
        		[
        			'value' => function ($data) { return substr($data->time, 0, 10); },
        			'label' => '日期',
        		],
        		[
        			'label' => '净值',
        			'value' => function ($data) { return $data->fvalue; },
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
                        $params[0] = 'fund-value/' . $action;
                        return Url::toRoute($params);
                    }
        		],
        	],
        ]);?>
        <?php Pjax::end();?>
    </div>
</div>
</div> <!-- for unexpect end -->
