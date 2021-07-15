<?php

use common\models\Notify;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\NotifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="notify-index">


<div class="col-sm-12">
    <div class="row col-sm-12">
        <button class="btn btn-info btn-round btn-just-icon pull-right"
                data-load="#dashboard-modal"
                data-url="<?=Url::toRoute(["/notify/create", "fid" => $fid, "download" => 0]);?>"
                data-content="添加" data-toggle="popover">
            <i class="material-icons">add</i>
        </button>
        <button class="btn btn-info btn-round btn-just-icon pull-right" style="margin-right: 1em"
                data-load="#dashboard-modal"
                data-url="<?=Url::toRoute(["/notify/create", "fid" => $fid, "download" => 1]);?>"
                data-content="添加" data-toggle="popover">
            <i class="material-icons">swap_vert</i>
        </button>
    </div>
    <?php Pjax::begin([
        	"id" => "NotifyContainer",
            'options' => [
                'data-reload-url' => Url::to(["notify/index", "fid" => $fid])
            ]
        ]);
    ?>
    <?=GridView::widget([
    	'summary' => false,
    	'emptyText' => "暂时没有纪录",
        'tableOptions' => ["class" => "table text-left"],
    	'dataProvider' => $dataProvider,
    	'columns' => [
    		[
    			'label' => '名称',
    			'value' => function ($data) {
    				return $data->title;
    			},
    		],
    		[
    			'label' => '类型',
    			'value' => function ($data) {
    				return Notify::Type()[$data->type];
    			},
    		],
    		[
    			'label' => '是否展示',
    			'value' => function ($data) {
    				return $data->isShow ? '是' : '否';
    			},
    		],
            [
                'class' => 'jackh\material\ActionColumn',
                'visibleButtons' => ["view" => false],
                'specialOptions' => [
                    'delete' => ['pjax-delete' => "notify"],
                    'update' => ['data-load' => "#dashboard-modal"],
                ],
                'urlCreator' => function($action, $model, $key, $index) {
                    $params = is_array($key) ? $key : ['id' => (string) $key];
                    $params[0] = 'notify/' . $action;
                    return Url::toRoute($params);
                }
            ],
		],
    ]);?>
    <?php Pjax::end();?>
    </div>
</div>
