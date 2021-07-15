<?php

/* @var $this yii\web\View */
/* @var $model common\models\CompanyImage */

?>
<div class="company-image-update">
    <div class="modal-header">
        <h4 class="modal-title">创建职场风采图片</h4>
    </div>
    <?=$this->render('_form', [
        'model' => $model,
        'cid' => $model->cid])?>
</div>
