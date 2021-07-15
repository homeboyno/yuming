<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FundManager */

$this->title = Yii::t('app', 'Create Fund Manager');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fund Managers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fund-manager-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
