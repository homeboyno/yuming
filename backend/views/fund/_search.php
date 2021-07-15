<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FundSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-search">

    <div class="modal-header">
            <h4 class="modal-title">产品搜索</h4>
    </div>

    <?php $form = ActiveForm::begin([
	'action' => ['search'],
	'method' => 'post',
	'options' => [
		'data-load' => '#dashboard-list',
	],
]);?>

    <div class="col-xs-6">
        <?=$form->field($model, 'name')?>
    </div>

    <div class="col-xs-12">
        <?=Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
