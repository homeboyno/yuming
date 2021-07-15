<?php

use jackh\aurora\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$reload_url = "/dashboard/fund-value/index?fid=$fund->id";

$script = <<< JS
    $(document).on('click', '#fund-value-import-save', function() {
        var url = $('#fund-value-import-save-form').attr('action'),
            that = $(this)
        $.ajax({
             type: 'POST',
             url: url,
             data: $("#fund-value-import-save-form").serializeArray(),
        })
        .success(function(response) {
            Alert($('#dashboard-modal'), response)
            if(response.success) {
                $.pjax.reload('#FundValueContainer', {url: '$reload_url', push: false, replace: false})
                $('#dashboard-modal').modal('hide')
            }
        })
    })
JS;
$this->registerJs($script);
?>
<div class="fund-value-import-confirm">
    <div class="modal-header">
        <h4 class="modal-title">确认净值数据</h4>
    </div>
    <div class="modal-body notify-form">
        <div class="alert alert-warning" role="alert">
            <p>标记为红色的数据是不符合数据规则的，<strong>不会被导入</strong>，请修改后再添加</p>
        </div>
<?php $form = ActiveForm::begin([
	"action" => Url::to(['/fund-value/import-save', 'id' => $fund->id]),
	"id" => 'fund-value-import-save-form',
]);?>
        <table class="table table-bordered">
            <tr>
                <th>日期</th>
                <th>净值</th>
            </tr>
<?php foreach ($failed as $row): ?>
            <tr class="text-danger">
                <?php
                    echo Html::tag("td", $row["日期"]);
                    echo Html::tag("td", $row["净值"]);
                ?>
            </tr>
<?php endforeach;?>
<?php foreach ($data as $row): ?>
            <tr>
                <?php
                    echo Html::tag("td", $row["日期"] . Html::hiddenInput("FundValue[time][]", $row["日期"]));
                    echo Html::tag("td", $row["净值"] . Html::hiddenInput("FundValue[fvalue][]", $row["净值"]));
                ?>
            </tr>
<?php endforeach;?>
        </table>
            <?=Html::submitButton("确认", ['id' => 'fund-value-import-save', 'class' => 'btn btn-primary'])?>
<?php ActiveForm::end();?>

    </div>
</div>
