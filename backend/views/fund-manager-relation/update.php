<?php

use jackh\material\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FundManagerRelation */

?>

<div class="modal-header">
    <h4 class="modal-title">管理基金经理</h4>
</div>

<div class="fund-manager-relation-update">
    <?php $form = ActiveForm::begin(['layout' => 'inline', 'method' => 'POST']);?>
    <div class="form-group col-xs-12">
    <?php
        foreach ($relations as $index => $relation) {
        	$avatar = Html::tag('img', '', ["src" => $relation->portrait ? $relation->portrait : '/images/fallback-avatar.jpg', "class" => "img-rounded img-responsive img-raised"]);
        	$name = Html::tag('p', $relation->name, ["style" => "margin-top: 1em; display: inline"]);
        	if ($relation->getWithChoosen($fid)->one() != NULL) {
        		$relation->choosen = 1;
        	}
        	$checkbox = $form->field($relation, "[$index]choosen")->checkbox(["label" => $relation->name]);
        	echo Html::tag("div", $avatar . $checkbox, ["class" => "col-xs-3 text-center"]);
        }
    ?>
    </div>
    <div class="form-group col-xs-12">
        <?=Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
