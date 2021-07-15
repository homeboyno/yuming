<?php

use jackh\aurora\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundAbstract */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modal-body fund-abstract-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-xs-6">
        <?=$form->field($model, 'type')->textInput()?>
    </div>

    <div class="col-xs-6">
        <?=$form->field($model, 'info')->textInput()?>
    </div>

    <div class="col-xs-12">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
