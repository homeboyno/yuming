    <div class="col-md-10 col-xs-12" style="margin-top: 20px">
        <div class="col-sm-5 col-xs-12">
            <div class="form-group">
                <label>密码</label>
                <input type="password" class="form-control" id="password" placeholder="密码">
            </div>
            <div class="form-group">
                <label>确认密码</label>
                <input type="password" class="form-control" id="repassword" placeholder="确认密码">
            </div>
            <button id="UpdatePwdSubmit" class="btn btn-primary">提交</button>
        </div>
    </div>

    <?php

use yii\web\View;
$this->registerJs('
    $("#UpdatePwdSubmit").on("click", function() {
        var pwd = $("#password").val();
        var repwd = $("#repassword").val();
        if (pwd.length < 8) {
            Alert($("#dashboard-content"), {success: false, message: "密码长度不能小于8位"});
            return;
        }
        if (pwd != repwd) {
            Alert($("#dashboard-content"), {success: false, message: "密码不一致"});
            return;
        }
        var result = $.post("site/update-password", {
            "UpdatePwdForm[password]": md5(pwd)
        });
        if (result.success) {
            Alert($("#dashboard-content"), {success: true, message: "密码已重置"});
        } else {
            Alert($("#dashboard-content"), {success: false, message: "由于网络原因重置失败，请稍后重试"});
        }
    })
', View::POS_END);