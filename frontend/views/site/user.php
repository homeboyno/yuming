<?php

use common\models\Appointment;
use yii\grid\GridView;
frontend\assets\AboutAsset::register($this);
// include 'inner-banner.php';
?>

    <div class="container">
        <div class="col-xs-0 col-md-2">
        </div>
        <div class="col-md-10" style="margin-top: 20px;">
<?=GridView::widget([
	'dataProvider' => $dataProvider,
	'summary' => false,
	'emptyText' => "没有用户",
	'tableOptions' => ['class' => 'table table-hover table-responsive'],
	'columns' => [
		[
			'value' => function ($data) {
				return $data->username;
			},
			'label' => '姓名',
		],
		[
			'value' => function ($data) {
				return $data->phone;
			},
			'label' => '电话',
		],
		[
			'value' => function ($data) {
				return $data->certificate;
			},
			'label' => '证件',
		],
		// [
		// 	'value' => function ($data) {
		// 		return $data->num;
		// 	},
		// 	'label' => '证件编号',
		// ],
	],
]);?>