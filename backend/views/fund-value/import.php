<?php

use yii\helpers\Html;

$this->registerJs("
    $('#fund-value-import').click(function() {
        var CSRFtoken = $('meta[name=csrf-token]').attr('content');
        zEvent.emit('upload', {
            url: '/dashboard/fund-value/import?id=$fund->id',
            name: 'excel',
            filter: '(\.|\/)(xls|xlsx)$',
            tips: '支持上传的文件格式xlsx, xls, 文件大小不超过5M',
            maxsize: 5*1024*1024,
            beforeSend: function(xhr, data) {
                xhr.setRequestHeader('X-CSRF-Token', CSRFtoken);
            },
            done: function(e, data) {
                data.context.find('[target=\"status\"]').addClass(\"animated fadeInUp\").text(\"上传成功\") // tips
                data.context.find('.status').addClass('checked')
                setTimeout(function() {
                    data.context.find('.status .fa-check').css({ 'display': 'block' })
                    data.context.find('.status .fa-times').css({ 'display': 'none' })
                }, 800)
                $('body').html(data.result)
            }
        })
    })
")
?>


<div class="fund-value-import">
    <div class="modal-header">
        <h4 class="modal-title">导入基金净值</h4>
    </div>
    <div class="modal-body notify-form">
        <div class="alert alert-warning" role="alert">
            <p>请上传Excel表格，其第一列必须是<strong>日期</strong>，第二列必须是<strong>净值</strong>，<strong>请严格遵循此规则，否则可能导致过往数据出错！</strong></p>
            <p><strong>重复日期的数据会自动忽略</strong></p>
            <p><strong>Excel表格式如下：</strong></p>
        </div>
        <table class="table">
            <tr><th>日期</th><th>净值</th></tr>
            <tr><td>2016-05-03</td><td>1.002</td></tr>
            <tr><td>2016-05-04</td><td>1.002</td></tr>
            <tr><td>2016-05-05</td><td>1.004</td></tr>
        </table>
        <?=Html::submitButton("上传", ['id' => 'fund-value-import', 'class' => 'btn btn-primary'])?>
    </div>
</div>
