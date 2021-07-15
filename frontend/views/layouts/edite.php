<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;

frontend\assets\EditeAsset::register($this);

$this->registerJs('
    $(document).ready(function() { zEvent.emit("resize-edite") })
    setTimeout(function() { zEvent.emit("resize-edite") }, 1000)
');
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title>友山基金管理有限公司</title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
    <?= $content ?>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
