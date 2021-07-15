<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <div class="modal-header">
        <h4 class="modal-title">用户搜索</h4>
    </div>

    <?php $form = ActiveForm::begin([
    	'action' => ['search'],
    	'method' => 'post',
    	'options' => [
    		'data-load' => '#dashboard-list',
    	],
    ]);?>

    <div class="col-xs-6">
        <?= $form->field($model, 'username')?>
    </div>

    <div class="col-xs-6">
        <?= $form->field($model, 'phone')?>
    </div>

    <div class="col-xs-6">
        <?= $form->field($model, 'certificate')?>
    </div>

    <?php // echo $form->field($model, 'accessToken') ?>

    <?php // echo $form->field($model, 'face') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'riskscore') ?>

    <?php // echo $form->field($model, 'agreecontract') ?>

    <?php // echo $form->field($model, 'type') ?>


    <?php // echo $form->field($model, 'certificate_type') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="col-xs-12">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
