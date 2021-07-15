<?php

/* @var $this yii\web\View */
/* @var $model app\models\News */

// $this->title = Yii::t('app', 'Create News');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-create">

    <div class="modal-header">
        <h4 class="modal-title">创建党建工作图片</h4>
    </div>
    
    <?=$this->render('_form', ['model' => $model])?>
</div>
