<?php

use yii\helpers\Html;
use jackh\aurora\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Download */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="download-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isShow')->textInput() ?>

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary', 'style' => 'position: absolute; top: 20px']) ?>

    <?php ActiveForm::end(); ?>

</div>
