<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modal-body fund-value-form">

    <?php $form = ActiveForm::begin(["options" => ["style" => "display: block; overflow: auto"]]);?>

    <div class="col-xs-6">
        <?=$form->field($model, 'time')->datepicker()?>
    </div>

    <div class="col-xs-6">
        <?=$form->field($model, 'fvalue')->textInput(['maxlength' => true])?>
    </div>

    <div class="form-group col-xs-12">
        <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>
</div>
