<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <?=Html::csrfMetaTags()?>
    <title>友山基金管理有限公司</title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
    <?=$content?>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
