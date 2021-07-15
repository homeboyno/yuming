<?php

/* @var $this yii\web\View */
/* @var $model common\models\Notify */

?>
<div class="notify-create">
    <div class="modal-header">
        <h4 class="modal-title">信息公示</h4>
    </div>
    <?=$this->render($model->download == '1' ? '_create_form' : '_form', [ 'model' => $model ])?>
</div>
