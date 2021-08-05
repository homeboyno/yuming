<?php

use yii\helpers\Url;
use yii\helpers\Html;

preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $model["content"], $matches);
if ($matches == null) {
	$backimages = [
		'/images/news-defualt-01.jpg',
		'/images/news-defualt-02.jpg',
		'/images/news-defualt-03.jpg',
		'/images/news-defualt-04.jpg',
		'/images/news-defualt-05.jpg',
	];
	$img_index = (int) $model["id"] % count($backimages);
	$img = $backimages[$img_index];
} else {
	$img = $matches[2];
}
$content = strip_tags($model["content"]);
$content = substr($content, 0, 421);
$date = date('Y-m-d', strtotime($model["createtime"]));
$baseUrl = Yii::$app->request->getPathInfo();
$detailUrl = [
    'news/index' => 'news/detail',
    'site/history' => 'site/history-detail',
];
$url = Url::to([$detailUrl[$baseUrl], "id" => $model["id"]]);
$pg = $widget->dataProvider->getPagination();
$leftItem = $pg->totalCount - $pg->getPageSize() * $pg->getPage();
$currentPageCount = $leftItem < $pg->getPageSize() ? $leftItem : $pg->getPageSize();
?>
<?= $index % 3 == 0 ? '<div class="row">' : '' ?>
<div class="col-xs-12 col-sm-4">
    <div class="card card-blog">
<?php if ($matches): ?>
        <div class="card-image">
            <a href="#pablo">
                <img class="img" src="<?=$img?>">
            </a>
        </div>
<?php endif; ?>
        <div class="content">
            <h4 class="card-title">
                <?=Html::a($model["title"], $url) ?>
            </h4>
            <p class="card-description">
                <?=$content ?>
            </p>
            <!-- <div class="footer">
                <div class="stats">
                    <i class="material-icons">schedule</i> <?=$date?>
                </div>
            </div> -->
        </div>
    </div>
</div>
<?= $index % 3 == 2 || ($index + 1) == $currentPageCount ? '</div>' : '' ?>
