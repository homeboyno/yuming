<?php

use jackh\aurora\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modal-body company-image-form">
    <?php $form = ActiveForm::begin();?>

    <div class="col-xs-12">
        <?=$form->field($model, 'info')->textInput(['maxlength' => true])?>
    </div>


    <div class="col-xs-12">
        <img id="imageUpload"
                src="<?=$model->url ? $model->url : '/images/fallback.png'?>"
                style="width: 100%" />
        <?=Html::hiddenInput("CompanyImage[url]", $model->url);?>
    </div>

    <div class="col-xs-12">
        <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ["class" => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>

<?php
$this->registerJs("
    $('#imageUpload').click(function() {
        var CSRFtoken = $('meta[name=csrf-token]').attr('content');
        zEvent.emit('upload', {
            url: '/dashboard/company-image/upload?cid=$cid',
            name: 'CompanyImage[imageFile]',
            beforeSend: function(xhr, data) {
                xhr.setRequestHeader('X-CSRF-Token', CSRFtoken);
            },
            done: function(e, response) {
                $('#imageUpload').attr('src', response.result.data.url)
                $('[name=\"CompanyImage[url]\"').val(response.result.data.url)
            }
        })
    })
");
?>
