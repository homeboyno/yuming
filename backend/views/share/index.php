<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ShareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="share-index">
    <div class="col-sm-12">
        <div class="row col-sm-12">
            <button class="btn btn-info btn-round btn-just-icon pull-right"
                    data-load="#dashboard-modal"
                    data-url="<?=Url::toRoute(["/share/create", "user_id" => $user_id]);?>"
                    data-content="添加" data-toggle="popover">
                <i class="material-icons">add</i>
            </button>
        </div>
        <?php Pjax::begin([
            "id" => "ShareContainer",
            'options' => [
                'data-reload-url' => Url::to(["/share/index", "user_id" => $user_id])
            ]
        ]);?>
        <?=GridView::widget([
        	'summary' => false,
        	'emptyText' => "暂时没有纪录",
        	'dataProvider' => $dataProvider,
            'tableOptions' => ["class" => "table"],
        	'columns' => [
        		[
        			'value' => function ($data) {
        				return $data->fund ? $data->fund->name : "未设置";
        			},
        			'label' => '基金名称',
        		],
        		[
        			'label' => '最新净值',
        			'value' => function ($data) {
        				return $data->fund && $data->fund->lastFundValue ? $data->fund->lastFundValue->fvalue : '未设置';
        			},
        		],
        		[
                    'label' => '净值日期',
        			'value' => function ($data) {
        				$time = $data->fund && $data->fund->lastFundValue ? $data->fund->lastFundValue->time : '未设置';
        				return substr($time, 0, 10);
        			},
        		],
        		[
        			'label' => '份额',
        			'value' => function ($data) {
        				return $data->share;
        			},
        		],
        		[
        			'label' => '参考市值',
        			'value' => function ($data) {
        				$fvalue = $data->fund && $data->fund->lastFundValue ? $data->fund->lastFundValue->fvalue : 0;
        				return $data->share * $fvalue;
        			},
        		],
                [
                    'class' => 'jackh\material\ActionColumn',
                    'visibleButtons' => ["view" => false],
                    'specialOptions' => [
                        'delete' => ['pjax-delete' => "share"],
                        'update' => ['data-load' => "#dashboard-modal"],
                    ],
                    'urlCreator' => function($action, $model, $key, $index) {
                        $params = is_array($key) ? $key : ['id' => (string) $key];
                        $params[0] = 'share/' . $action;
                        return Url::toRoute($params);
                    }
                ],
        	],
        ]);?>
        <?php Pjax::end();?>
    </div>
</div>
