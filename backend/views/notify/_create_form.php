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

        <div class="col-xs-6 form-group" style="margin-top: 27px">
            <?php if ($model->content != ''): ?>
                <a class="btn btn-primary" id="notifylink" href="<?=$model->content?>">下载</a>
            <?php endif; ?>
            <a class="btn btn-primary" id="notify-file">上传</a>
            <?=Html::hiddenInput("Notify[content]", $model->content);?>
        </div>

        <footer class="col-xs-12">
            <?=Html::submitButton(Yii::t('app', $model->isNewRecord ? 'Create' : 'Update'), ['class' => 'btn btn-primary pull-right', 'style' => 'margin: -10px 0 0 2em;'])?>
            <?=$form->field($model, 'isShow', ["options" => ["class" => "pull-right"]])->switch()?>
        </footer>

        <?php ActiveForm::end();?>

</div>

<?php
$this->registerJs("
    $('#notify-file').click(function() {
        var CSRFtoken = $('meta[name=csrf-token]').attr('content');
        zEvent.emit('upload', {
            url: '/dashboard/notify/file-upload',
            name: 'Notify[file]',
            filter: '(\.|\/)(zip|7z|rar|tar|pdf|doc|docx|xls|xlsx)$',
            tips: '支持上传的文件格式zip, 7z, rar, tar, pdf, doc, docx, xlsx, xls, 文件大小不超过5M',
            maxsize: 5*1024*1024,
            beforeSend: function(xhr, data) {
                xhr.setRequestHeader('X-CSRF-Token', CSRFtoken);
            },
            done: function(e, data) {
                var url = data.result.data.url;
                if ($('#notifylink').length == 0) {
                    var newdom = $('<a class=\"btn btn-primary\" id=\"notifylink\">下载</a>').attr('href', url)
                    $('#notify-file').parent().append(newdom)
                } else {
                    $('#notifylink').attr('href', url)
                }
                $('[name=\"Notify[content]\"]').val(url)
            }
        })
    })
");
?>
