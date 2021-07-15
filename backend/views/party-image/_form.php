<?php

use jackh\aurora\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\FundManager */
/* @var $form yii\widgets\ActiveForm */
$uploadButtonId = "PartyImageUpload" . rand();
?>

<div class="modal-body party-image-form">
    <?php $form = ActiveForm::begin();?>

    <div class="col-xs-12">
        <?=$form->field($model, 'info')->textInput(['maxlength' => true])?>
    </div>

    <div class="col-xs-12">
        <img id="<?=$uploadButtonId?>"
                src="<?=$model->url ? $model->url : '/images/fallback.png'?>"
                style="width: 100%"/>
        <?=Html::hiddenInput("PartyImage[url]", $model->url);?>
    </div>

    <div class="col-xs-12">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ["class" => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>

<?php
$this->registerJs("
    $('#$uploadButtonId').click(function() {
        var CSRFtoken = $('meta[name=csrf-token]').attr('content');
        zEvent.emit('upload', {
            url: '/dashboard/party-image/upload',
            name: 'PartyImage[imageFile]',
            beforeSend: function(xhr, data) {
                xhr.setRequestHeader('X-CSRF-Token', CSRFtoken);
            },
            done: function(e, response) {
                $('#$uploadButtonId').attr('src', response.result.data.url)
                $('[name=\"PartyImage[url]\"').val(response.result.data.url)
            }
        })
    })
");
?>
