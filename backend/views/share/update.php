<?php

/* @var $this yii\web\View */
/* @var $model common\models\Share */

?>
<div class="share-update">
    <div class="modal-header">
        <h4 class="modal-title">份额</h4>
    </div>
<?=$this->render('_form', [
	'model' => $model,
])?>

</div>
