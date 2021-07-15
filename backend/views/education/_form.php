<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;
use common\models\Education;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-6">
        <?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'createtime')->datepicker()?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'type')->dropdownList(Education::typeOptions())?>
    </div>

    <div class="col-sm-12">
        <?=$form->field($model, 'content')->editor()?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=$form->field($model, 'isShow')->switch()?>
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <?php ActiveForm::end();?>

</div>
