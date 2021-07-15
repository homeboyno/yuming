<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ShareSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="share-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-load' => '#dashboard-list',
        ],
    ]); ?>

    <?= $form->field($model, 'fund_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'fund_type') ?>

    <?= $form->field($model, 'share') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
