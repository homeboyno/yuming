<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-6">
        <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'address')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'charger')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'weight')->textInput()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'fax')->textInput()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'zuoji')->textInput()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'kefu')->textInput()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'postcode')->textInput()?>
    </div>

    <div class="col-sm-12">
        <?=$form->field($model, 'function')->textarea(['rows' => 12])?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=$form->field($model, 'isShow')->switch()?>
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <?php ActiveForm::end();?>

</div>
