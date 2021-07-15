<?php
use jackh\dashboard\ListMenu;
use jackh\dashboard\HtmlProcess;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="news-index">
    <?=ListMenu::render(["create" => ["create", "type" => $type]])?>
    <?=ListView::widget([
    	'dataProvider' => $dataProvider,
        'options' => ['class' => 'dashboard-list'],
    	'itemOptions' => ['class' => 'item'],
    	'summary' => '',
    	'itemView' => function ($model, $key, $index, $widget) {
    		$widget->itemOptions = array_merge($widget->itemOptions, [
    			"data-url" => Url::toRoute(['update', 'id' => $model->id]),
    			"data-delete-url" => Url::toRoute(['delete', 'id' => $model->id]),
    			"data-load" => "#dashboard-content",
    		]);
    		$title = Html::tag("p", Html::encode($model->title), ["class" => "title"]);
            $content = Html::tag('p',
                $model->content ? Html::encode(HtmlProcess::processParagraph($model->content, 200))
                                : Yii::t('app', 'Not Set'),
                ['class' => 'text']);
            $date = Html::tag("p", Html::encode($model->createtime), ["class" => "text-muted"]);
    		return Html::tag("div", $title . $content . $date, ["class" => "content"]);
    	},
    	'pager' => [
    		'linkOptions' => ["data-load" => "#dashboard-list"],
    	],
    	'emptyText' => '<div class="text-center" style="margin-top: 120px;"><i class="fa fa-bookmark-o" style="font-size: 40px"></i><h3>' . Yii::t('app', 'no result found') . '</h3></div>',
    ])?>
</div>
