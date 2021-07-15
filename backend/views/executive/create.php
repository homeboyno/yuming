<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Executive */

$this->title = Yii::t('app', 'Create Executive');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Executives'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="executive-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
