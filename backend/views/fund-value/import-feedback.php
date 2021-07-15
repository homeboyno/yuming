<?php

use jackh\aurora\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$script = <<< JS
    $('#modal-close').click(function() {
        zEvent.emit('modal-close', {});
    })
JS;
$this->registerJs($script);
?>
<div class="fund-value-import-feedback">
    <div class="modal-header">
        <h4 class="modal-title">净值导入反馈</h4>
    </div>
    <div class="modal-body notify-form">
        <div class="alert alert-warning" role="alert">
            <p>以下为导入失败的净值记录，请核对！</p>
        </div>
        <table class="table table-bordered">
            <tr>
                <th>日期</th>
                <th>净值</th>
                <th>错误原因</th>
            </tr>
<?php foreach ($failed as $row): ?>
            <tr>
                <?php
                    echo Html::tag("td", $row["日期"]);
                    echo Html::tag("td", $row["净值"]);
                    echo Html::tag("td", $row["message"]);
                ?>
            </tr>
<?php endforeach;?>
        </table>
        <?=Html::submitButton("确认", ['id' => 'modal-close', 'class' => 'btn btn-primary'])?>
    </div>
</div>
