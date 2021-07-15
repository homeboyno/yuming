<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use jackh\material\ActiveForm;
use common\models\User;

frontend\assets\SiteAsset::register($this);
$this->registerJs($this->render('forgot-pwd.js'));
?>
<div class="site-login" style="overflow: auto; padding-bottom: 50px">
    <div class="row col-xs-12 text-center">
        <div class="modal-header ushinef-modal">
            <h1 class="modal-title"><?=Yii::t('app','重置密码')?></h1>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'update-pwd-form']); ?>

            <?= $form->field($model, 'token')->textInput(['placeholder' =>Yii::t('app',"手机号码")])->label(false) ?>

            <div class="multiple">
                <div class="form-group field-registerform-verify required has-success">
                    <input type="text" id="registerform-verify" class="form-control" name="UpdatePwdForm[verify]" placeholder=<?=Yii::t('app',"验证码")?>>
                    <p class="help-block help-block-error"></p>
                </div>
                <span class="gap"></span>
                <img src="/site/captcha" class="captcha" lt=<?=Yii::t('app',"验证码")?>>
            </div>

            <div class="multiple">
                <?= $form->field($model, 'captcha')->textInput(["placeholder" => Yii::t('app',"短信验证码")])->label(false) ?>
                <span class="gap" style="width: 20px"></span>
                <button class="btn-ushinef btn-sm" id="send-verify"><?=Yii::t('app','发送验证码')?></button>
            </div>

            <?= $form->field($model, 'password')->passwordInput(["placeholder" =>Yii::t('app',"密码")])->label(false) ?>

            <div class="summary"></div>

            <div class="form-group">
                <button class="btn-ushinef" type="submit"><?=Yii::t('app','重置')?></button>
            </div>

        <?php ActiveForm::end(); ?>
        <div class="modal-footer ushinef-modal">
            <div class="UserTrigger">
                <button class="pull-left" onClick="window.location='/site/login'"><?=Yii::t('app','登录')?></button>
                <button class="pull-right" onClick="window.location='/site/register'"><?=Yii::t('app','注册')?> <i class="fa fa-hand-o-right "></i></button>
            </div>
        </div>
    </div>
</div>

<style>
.site-login .form-group .help-block { display: none; }
.site-login .form-group { margin-bottom: 0; }
</style>
