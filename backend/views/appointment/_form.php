<?php

use common\models\Appointment;
use common\models\User;
use jackh\aurora\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
?>
<style media="screen">
    .form-group {
        margin: 0;
    }
</style>
<div class="appointment-form">

    <?php $form = ActiveForm::begin();?>
    <div class="col-sm-12">
       <h3>预约信息</h3>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'status')->dropDownList(Appointment::Status())?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'money')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'createtime')->textInput(['disabled' => true])?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <div class="col-sm-12">
       <h3>用户信息</h3>
   </div>
    <div class="col-sm-6">
        <label class="control-label">用户姓名</label>
        <input type="text" class="form-control" value="<?=$model->user->username;?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">手机</label>
        <input type="text" class="form-control" value="<?=$model->user->phone;?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">邮箱</label>
        <input type="text" class="form-control" value="<?=$model->user->email;?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">用户证件</label>
        <input type="text" class="form-control" value="<?=$model->user->certificate;?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">证件类型</label>
        <input type="text" class="form-control" value="<?=User::certificateType()[$model->user->certificate_type]?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">用户风险测试类型</label>
        <input type="text" class="form-control" value="<?=$model->riskType?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-12">
       <h3>基金信息</h3>
   </div>
    <div class="col-sm-6">
        <label class="control-label">基金名称</label>
        <input type="text" class="form-control" value="<?=$model->fund ? $model->fund->name : ""?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">最新基金净值</label>
        <input type="text" class="form-control" value="<?=$model->fund && $model->fund->lastFundValue ? $model->fund->lastFundValue->fvalue : 0?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <div class="col-sm-6">
        <label class="control-label">最新基金日期</label>
        <input type="text" class="form-control" value="<?=$model->fund && $model->fund->lastFundValue ? substr($model->fund->lastFundValue->time, 0, 10) : '1970-01-01'?>" disabled>
        <p class="help-block help-block-error"></p>
    </div>

    <?php ActiveForm::end();?>

</div>
