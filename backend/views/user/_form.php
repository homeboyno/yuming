<?php

use common\models\User;
use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-6">
        <?=$form->field($model, 'username')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'phone')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'email')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'riskscore')->textInput()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'certificate_type')->dropdownList(User::certificateType())?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'certificate')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'type')->dropdownList(User::userType())?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'address')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'is_active')->switch(['disabled' => true]) ?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <?php ActiveForm::end();?>

</div>
