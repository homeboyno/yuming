<?php
use yii\helpers\Html;
use yii\helpers\Url;

frontend\assets\CommonAsset::register($this);
?>
<style>
    .ntitle {
        border-bottom: 1px solid #ddd;
        padding: 0.67em 0;
    }

    .createtime {
        width: 100%;
        padding-bottom: 0;
        text-align: right;
    }
</style>
<div>
    <h1 class="ntitle"><?=$model->title;?></h1>
    <p class="createtime">
        <i class="fa fa-clock-o"></i>
        <?=date('Y-m-d', strtotime($model->createtime));?>
    </p>
    <div style="margin-top: 20px">
        <iframe class="edite" onload="this.height=this.contentWindow.document.body.scrollHeight"  src="/edite/view?type=glory&id=<?=$model->id?>"></iframe>
    </div>
    <div class="col-sm-12 row">
        <div>
<?php
if ($before["id"] != null) {
    echo Html::a('上一篇：' . $before['title'], Url::to(['/site/history-detail', "id" => $before["id"]]), ["style" => "margin: 1em 0;"]);
}
?>
        </div>
        <div style="float:left">
<?php
if ($after["id"] != null) {
    echo Html::a('下一篇：' . $after['title'], Url::to(['/site/history-detail', "id" => $after["id"]]), ["class" => "pull-right", "style" => "margin: 1em 0;"]);
}
?>
        </div>
    </div>
</div>
