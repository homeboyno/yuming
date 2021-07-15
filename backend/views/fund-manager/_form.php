<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fund-manager-form">
    <?php $form = ActiveForm::begin();?>
    <div class="col-sm-6">
        <img id="fund-manager-portrait" src="<?=$model->portrait ? $model->portrait : '/images/fallback-avatar.jpg'?>" class="img-rounded img-responsive img-raised" />
        <?=Html::hiddenInput("FundManager[portrait]", $model->portrait);?>
    </div>
    <div class="col-sm-6">
        <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'position')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'company')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-sm-6">
        <?=$form->field($model, 'weight')->textInput()?>
    </div>

    <div class="col-sm-12">
        <?=$form->field($model, 'detail')->textarea(['rows' => 6])?>
    </div>

    <footer class="col-sm-12 content-footer animated fadeInUp delay-05">
      <div class="pull-right">
        <?=$form->field($model, 'isShow')->switch()?>
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary'])?>
      </div>
    </footer>

    <?php ActiveForm::end();?>

</div>

<?php
$this->registerJs("
    $('#fund-manager-portrait').click(function() {
        var CSRFtoken = $('meta[name=csrf-token]').attr('content');
        zEvent.emit('upload', {
            url: '/dashboard/fund-manager/upload',
            name: 'FundManager[imageFile]',
            beforeSend: function(xhr, data) {
                xhr.setRequestHeader('X-CSRF-Token', CSRFtoken);
            },
            done: function(e, response) {
                $(\"#fund-manager-portrait\").attr(\"src\", response.result.data.url)
                $('[name=\"FundManager[portrait]\"]').val(response.result.data.url)
            }
        })
    })
");
?>
