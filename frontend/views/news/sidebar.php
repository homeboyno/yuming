            <div class="sidebar black hidden-xs" style="margin-top: 80px;">
                <div class="first-row"><?=Yii::t('app','友山动态')?></div>
                <div class="submenu">
                    <?php

use common\models\News;
use yii\helpers\Html;
use yii\helpers\Url;

foreach (News::typeToUrl() as $key => $value) {
    if ($key == "友山观点") continue;
	$a = Html::a($key, $value);
	echo Html::tag('div', $a, ["class" => strpos(Yii::$app->request->url, $value) === 0 ? "active" : ""]);
}
?>
                </div>
            </div>
