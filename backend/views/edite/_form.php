<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Edite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edite-form">

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-12">
        <?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-12">
        <?=$form->field($model, 'content')->editor()?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <?php ActiveForm::end();?>

</div>
