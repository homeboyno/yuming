<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;

frontend\assets\MainAsset::register($this);

$url = \Yii::$app->request->getPathInfo();
$sidebar = explode("/", $url)[0] . "Sidebar";
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title>友山教育咨询有限公司</title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
<?php include Yii::$app->basePath . '/views/layouts/Navigation.php';?>
<!-- <div id="main"> -->
    <?php 
        $showBanner = isset($this->params["Banner"]) ? $this->params["Banner"] : true;
        // if ($showBanner) {
        //     include Yii::$app->basePath . '/views/layouts/Banner.php';
        // }
    ?>
    <?php
        $showSidebar = isset($this->params["Sidebar"]) ? $this->params["Sidebar"] : true;
        if ($showSidebar) {
            $sidebarParams = include Yii::$app->basePath . '/views/layouts/Sidebar.php';
            $sidebar = \frontend\components\Sidebar::widget([
                "sidebar" => $sidebarParams[$sidebar]
            ]);
            $sidebarWrapper = Html::tag("div", $sidebar, ["class" => "col-lg-2 hidden-xs sidebar-left"]);
            $contentWrapper = Html::tag("div", $content, ["class" => "col-xs-12 col-lg-10 sidebar-right"]);
            echo Html::tag("div", $sidebarWrapper . $contentWrapper, ["class" => "container"]);
        } else {
            echo $content;
        }
    ?>
<!-- </div> -->
<?php
$showFooter = isset($this->params["Footer"]) ? $this->params["Footer"] : true;
if ($showFooter) {
	include Yii::$app->basePath . '/views/layouts/Footer.php';
}

include Yii::$app->basePath . '/views/layouts/scrolltop.php';
?>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
