<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use common\components\Instruction;

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
<body style="background: transparent;">
<?php $this->beginBody()?>
    <?=$content?>
    <?=Instruction::render() ?>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
