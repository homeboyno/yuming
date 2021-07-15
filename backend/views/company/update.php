<?php

use common\models\CompanyImageSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

?>
<div class="company-update" style="padding-bottom: 100px; overflow: auto;">

    <?=$this->render('_form', [ 'model' => $model])?>

    <?php
        $searchModel = new CompanyImageSearch();
        $dataProvider = $searchModel->search(["CompanyImageSearch" => ["cid" => $model->id]]);
        $dataProvider->setPagination(["pageSize" => 4, "route" => "/company-image/index", "params" => ["cid" => $model->id]]);

        echo $this->render('/company-image/index', [
        	'searchModel' => $searchModel,
        	'dataProvider' => $dataProvider,
        	'cid' => $model->id,
        ]);
    ?>
</style>
