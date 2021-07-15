<?php

/* @var $this yii\web\View */
/* @var $model common\models\FundAbstract */

?>
<div class="fund-abstract-create">
    <div class="modal-header">
        <h4 class="modal-title">创建基金缩略</h4>
    </div>
        <?=$this->render('_form', [
	'model' => $model,
])?>

</div>
