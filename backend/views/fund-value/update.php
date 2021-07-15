<?php

/* @var $this yii\web\View */
/* @var $model common\models\FundValue */

?>
<div class="fund-value-update">

    <div class="modal-header">
        <h4 class="modal-title">更新基金净值</h4>
    </div>
    <?=$this->render('_form', [
	'model' => $model,
])?>

</div>
