<?php

use common\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
backend\assets\LoginAsset::register($this);
$this->registerJsFile('/scripts/share/md5.js');
$this->registerJs('
	var password = "";
	$("#login-form").on("beforeSubmit", function(e) {
		password = $(this).find("[type=password]").val()
		$(this).find("[type=password]").val(hex_md5(password))
	})
');
?>

<style>
	.card-title {
		font-family: "Microsoft YaHei", "微软雅黑", STXihei, "华文细黑", serif;
		font-weight: 300
	}
</style>
<nav class="navbar navbar-primary navbar-transparent navbar-absolute animated fadeInDown">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a class="navbar-brand" href="/" style="height: 60px; border-radius: 4px">
				<img src="/images/ushineName-white.svg" alt="友山教育" style="width: 150px">
			</a>
		</div>
</nav>

<div class="page-header header-filter" style="background-image: url('/images/dashboard-bg01.jpg'); background-size: cover; background-position: top center;">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 animated fadeInUp">
				<div class="card card-signup">
					<?php $form = ActiveForm::begin(['id' => 'login-form']);?>
						<div class="header header-primary text-center">
							<!-- <img src="/images/ushinef-logo-3.svg" alt="友山基金" style="width: 50px"> -->
							<h4 class="card-title" style=>登&nbsp;&nbsp;&nbsp;&nbsp;录</h4>
						</div>
						<div class="content">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">phone</i>
								</span>
								<?=$form->field($model, 'token', ['options' => ['class' => 'form-group label-floating']])->textInput()?>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">lock_outline</i>
								</span>
								<?=$form->field($model, 'password', ['options' => ['class' => 'form-group label-floating']])->passwordInput()?>
							</div>

							<!-- <div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">verified_user</i>
								</span>

								<div class="col-xs-6" style="margin-top: 27px;">
									<img src="/dashboard/site/captcha" alt="">
								</div>
							</div> -->
						</div>
						<div class="footer text-center">
							<button class="btn btn-primary btn-simple btn-wd btn-lg" type="submit" name="login-button">登 录</button>
						</div>
					<?php ActiveForm::end();?>
				</div>
			</div>
		</div>
	</div>
</div>
