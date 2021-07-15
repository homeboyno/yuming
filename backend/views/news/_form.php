<?php

use common\models\Fund;
use common\models\News;
use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs($this->render('@backend/views/news/form.js'));
?>

<div class="news-form">
    <input type="file" name="file" style="display:none" accept="application/pdf" id="pdf" multiple="multiple" />

    <?php $form = ActiveForm::begin();?>

    <div class="col-sm-6">
        <?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'createtime')->datepicker()?>
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
