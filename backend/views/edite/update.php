<?php

use common\models\Edite;
use common\models\PartyImage;
use common\models\UnionImage;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\Edite */

?>
<div class="edite-update" style="padding-bottom: 100px; overflow: auto">
    <?=$this->render('_form', ['model' => $model])?>
    <?php
        if ($model->id == Edite::EDITE_TEST_ENVIRONEMENT) {
        	$dataProvider = new ActiveDataProvider(['query' => UnionImage::find()]);
        	echo $this->render('/union-image/index', ['dataProvider' => $dataProvider]);
        }
        // if ($model->id == Edite::EDITE_PARTY) {
        // 	$dataProvider = new ActiveDataProvider(['query' => PartyImage::find()]);
        // 	echo $this->render('/party-image/index', ['dataProvider' => $dataProvider]);
        // }
    ?>
</div>
