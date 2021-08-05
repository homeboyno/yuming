<?php

use yii\helpers\Url;
use yii\helpers\Html;
// if ($index % 3 == 0) {
// 	echo '<div class="row">';
// }
?>
<?php
preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $model["content"], $matches);


if (file_exists($matches[2]) && $matches != null) {
    $img = $matches[2];
} 
else{
	$backimages = [
		'/images/news-defualt-01.jpg',
		'/images/news-defualt-02.jpg',
		'/images/news-defualt-03.jpg',
		'/images/news-defualt-04.jpg',
		'/images/news-defualt-05.jpg',
	];
	$img_index = (int) $model["id"] % count($backimages);
	$img = $backimages[$img_index];
} 
$content = strip_tags($model["content"]);
$content = substr($content, 0, 499);
$baseUrl = Yii::$app->request->getPathInfo();
$url = Url::to(['news/detail', "id" => $model["id"]]);
?>

<div class="col-md-4 typ2-folios-item creati">
    <div class="single-folio-wraper2">
        <div class="folio-img-hvr2-wrape">
            <?=Html::img($img,['alt' => 'img', 'class' => 'img-fluid']) ?>
            <div class="folio-hvr2-pop">
                <?=Html::a(Html::tag('i', '', ['class' => 'fa fa-plus']), $url) ?>
            </div>
        </div>
        <div class="folio-hvr2-title">
            
            <?=Html::a($model["title"], $url) ?>
            <p class='card-description'><?=Html::encode($content) ?></p>
        </div>
    </div>
</div>

<style>
    .card-description {
        max-height: 5em;
        overflow: hidden;
        color: #999999;
    }
</style>


