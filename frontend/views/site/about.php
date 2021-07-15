<?php

frontend\assets\AboutAsset::register($this);

$sidebarParams = include Yii::$app->basePath . '/views/layouts/Sidebar.php';
?>

<div class="container">
    <div class="col-md-2 hidden-xs sidebar-left">
        <?=\frontend\components\Sidebar::widget([ "sidebar" => $sidebarParams["siteSidebar"] ])?>
    </div>
    <div class="col-xs-12 col-md-10 sidebar-right">
        <div class="us-title">
            <h2><?=Yii::t('app','走进友山')?></h2>
            <p><?=Yii::t('app','关于友山')?></p>
        </div>
        <div>
            <iframe class="edite" onload="this.height=this.contentWindow.document.body.scrollHeight" src="/edite/view?type=edite&id=1">123</iframe>
            <!-- <div>123</div> -->
        </div>
    </div>
</div>
<!-- <section class="color-section text-center" style="padding: 30px;">
    <h1><?=Yii::t('app','亲如友&nbsp;&nbsp;&nbsp;稳若山')?></h1>
    <p class="describe wp4" style="color: white"><?=Yii::t('app','公司一直致力于运用各类标准化金融工具和金融资产为客户提供财富管理服务，以“追求稳定的绝对正收益”为目标 ，以悉心全面、科学系统的客户服务为导向，致力于成为一家优秀的现代财富管理机构。')?></p>
    <div>
        <button class="btn btn-danger" onClick="window.location='/fund/recommand'"><?=Yii::t('app','我要投资')?></button>
    </div>
</section> -->
