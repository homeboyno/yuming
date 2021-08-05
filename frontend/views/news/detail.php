<?php
use yii\helpers\Html;
use yii\helpers\Url;
frontend\assets\AboutAsset::register($this);

$this->registerJs($this->render('@webroot/scripts/share/pdf.js'));

$this->registerJs($this->render('@frontend/views/news/detail.js'));
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
    .time-icon {
        font-size: 14px;
        line-height: 14px;
    }
    .justify-content-between {
        justify-content: space-between !important;
        padding-bottom: 40px;
    }
</style>
<div class="container">
    <h1 class="ntitle"><?=$news["title"];?></h1>
    <p class="createtime">
        <i class="material-icons time-icon">access_time</i>
        <?=date('Y-m-d', strtotime($news["createtime"]));?>
    </p>
    <div class= "contents" style="margin-top: 20px">
        <iframe id= "frameId" class="edite" onload="this.height=this.contentWindow.document.body.scrollHeight" src="/edite/view?type=news&id=<?=$news['id']?>"></iframe>
    </div>
    <div class="col-sm-12 row justify-content-between" >
        <!-- <div style="position:absolute;left:0px;border:1px solid red;">左边</div>
        <div style="position:absolute;right:0px;border:1px solid red;">右边</div> -->
        <div style="position:absolute;left:0px;border:1px;">
            <?php
                if ($before["id"] != null) {
                echo Html::a('上一篇：' . $before['title'], Url::to(['/news/detail', "id" => $before["id"]]), ["style" => "margin: 1em 0;"]);
                // echo "上";
                }
            ?>
        </div>
        <div style="position:absolute;right:0px;border:1px;">
            <?php
                if ($after["id"] != null) {
                echo Html::a('下一篇：' . $after['title'], Url::to(['/news/detail', "id" => $after["id"]]), ["class" => "pull-right"]);
                // echo "下";
                }
            ?>
        </div>
    </div>
</div>


