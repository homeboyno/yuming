<?php

/* @var $this yii\web\View */
/* @var $model common\models\FundAbstract */

?>
<div class="fund-abstract-update">
    <div class="modal-header">
        <h4 class="modal-title">更新基金缩略</h4>
    </div>
    <?=$this->render('_form', [
        'model' => $model,
    ])?>

</div>
