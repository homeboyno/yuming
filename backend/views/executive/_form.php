<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Executive */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="executive-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-6">
        <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'apartment')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'position')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'weight')->textInput()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'sex')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-12">
        <?=$form->field($model, 'profile')->textarea(['rows' => 6])?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=$form->field($model, 'isShow')->switch()?>
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <?php ActiveForm::end();?>

</div>
