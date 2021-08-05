<?php
use yii\helpers\Html;
use yii\helpers\Url;

frontend\assets\CommonAsset::register($this);
?>

    <div class="edite-detail container">
        <div class="col-md-2 hidden-xs">
            <?php include 'sidebar.php';?>
        </div>

        <div class="col-xs-12 col-md-10">
            <h1 class="title"><?=$news["title"];?></h1>
            <p class="time">
                <i class="fa fa-clock-o"></i>
                <?=date('Y-m-d', strtotime($news["createtime"]));?>
            </p>
            <div>
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
    </div>
