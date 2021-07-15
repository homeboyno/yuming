<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = Yii::t('app', 'Create Appointment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Appointments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
