<?php

use common\models\Notify;
use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Notify */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="modal-body notify-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-xs-6">
        <?=$form->field($model, 'type')->dropDownList(Notify::Type())?>
    </div>

    <div class="col-xs-6">
        <?=$form->field($model, 'createtime')->datepicker()?>
    </div>

    <div class="col-xs-6">
        <?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-xs-12">
        <?=$form->field($model, 'content', ["enableLabel" => false])->editor()?>
    </div>

    <footer class="col-xs-12">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary pull-right', 'style' => 'margin: -10px 0 0 2em;'])?>
        <?=$form->field($model, 'isShow', ["options" => ["class" => "pull-right"]])->switch()?>
    </footer>

    <?php ActiveForm::end();?>

</div>
