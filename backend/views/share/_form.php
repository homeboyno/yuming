<?php

use common\models\Fund;
use jackh\aurora\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Share */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modal-body share-form">

    <?php $form = ActiveForm::begin();?>
    <?=Html::hiddenInput('user_id', $model->user_id);?>
    <?=$form->field($model, 'fund_id', ["options" => ["class" => "col-sm-6"]])->dropDownList(Fund::chooseList())->label("基金名称")?>

    <?=$form->field($model, 'share', ["options" => ["class" => "col-sm-6"]])->textInput(['maxlength' => true])?>

        <div class="form-group col-sm-12">
    <?=Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])?>
    </div>
        <?php ActiveForm::end();?>

</div>
