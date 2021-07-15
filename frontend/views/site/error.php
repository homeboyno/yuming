<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

frontend\assets\AboutAsset::register($this);
Yii::$app->view->params = [ 'Sidebar' => false ];

?>
<div class="container">

    <h1><?=Html::encode($this->title)?></h1>

    <div class="alert alert-danger">
        <?=nl2br(Html::encode($message))?>
        <p>
            系统在处理您的请求时发生了错误。
        </p>
        <p>
            如果您认为这个系统错误，请您联系我们。谢谢！
        </p>

    </div>
</div>
