<?php
    
use \yii\helpers\Html;

$cookies = \Yii::$app->request->cookies;
// 获取名为 "language" cookie 的值，如果不存在，返回默认值 "zh-CN"
$language = $cookies->getValue('language', 'zh-CN');
$zhOptions = ["href" => "/site/set-language?language=zh-CN", "class" => "language"];
$enOptions = ["href" => "/site/set-language?language=en", "class" => "language"];
if ($language == "zh-CN") {
    Html::addCssClass($enOptions, "enable");
}
else {
    Html::addCssClass($zhOptions, "enable");
}

?>

<?= Html::tag("a", "中文", $zhOptions) ?>
|
<?= Html::tag("a", "English", $enOptions) ?>