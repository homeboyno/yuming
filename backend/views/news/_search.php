<?php

use jackh\aurora\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
	'action' => ['index'],
	'method' => 'get',
	'options' => [
		'data-load' => '#dashboard-list',
	],
]);?>

    <?=$form->field($model, 'title')?>

    <?=$form->field($model, 'content')?>

    <?=$form->field($model, 'createtime')->datepickerInput()?>

    <div class="form-group">
        <?=Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
