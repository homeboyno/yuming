<?php

use yii\web\View;

frontend\assets\AboutAsset::register($this);
include 'inner-banner.php';
?>
<div class="container">
    <div class="col-md-2">
        <?php include '_user_navbar.php';?>
    </div>
    <div class="col-md-10 col-xs-12" style="margin-top: 20px">
        <div class="col-sm-5 col-xs-12">
            <div class="form-group">
                <label><?=Yii::t('app','密码')?></label>
                <input type="password" class="form-control" id="password" placeholder="密码">
            </div>
            <div class="form-group">
                <label><?=Yii::t('app','确认密码')?></label>
                <input type="password" class="form-control" id="repassword" placeholder="确认密码">
            </div>
            <button type="submit" class="btn btn-default" onclick="UpdatePwdSubmit()"><?=Yii::t('app','提交')?></button>
            <div class="alert alert-danger" role="alert" style="display: none; margin-top: 10px"><?=Yii::t('app','密码不一致')?></div>
            <div class="alert alert-success" role="alert" style="display: none; margin-top: 10px"></div>
        </div>
    </div>
</div>
<?php
$this->registerJs('
    function UpdatePwdSubmit() {
        var pwd = $("#password").val();
        var repwd = $("#repassword").val();
        if (pwd.length < 8) {
            ErrorTip("密码长度不能小于8位");
            return;
        }
        if (pwd != repwd) {
            ErrorTip("密码不一致");
            return;
        }

        var result = $.post("/site/update-password", {
            "UpdatePwdForm[password]": hex_md5(pwd)
        });
        if (result.success) {
            $(".alert-success").text("密码已重置").show("fast");
        } else {
            ErrorTip("由于网络原因重置失败，请稍后重试");
        }
    }
', View::POS_END);
