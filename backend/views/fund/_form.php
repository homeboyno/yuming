<?php

use common\models\Fund;
use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Fund */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    #fund-risktype .row {
        display: inline;
        float: left;
        margin-left: 0;
        margin-right: 20px;
    }
</style>
<div class="fund-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-6">
        <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'weight')->textInput();?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'series')->textInput();?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'basetype')->dropDownList(Fund::FundType());?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'status')->dropDownList(Fund::FundStatus());?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'risktype')->dropDownList(Fund::RiskType());?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
        <div class="pull-left">
            <?=$form->field($model, 'recommand', ["options" => ["style" => "margin-top: 8px"]])->switch();?>
        </div>
        <div class="pull-right">
            <?=$form->field($model, 'isShow')->switch()?>
            <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
        </div>
    </footer>

    <?php ActiveForm::end();?>

</div>
