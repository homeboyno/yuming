<?php

use common\models\Share;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<div class="user-update" style="padding-bottom: 100px; overflow: auto">
	<?=$this->render('_form', [ 'model' => $model ])?>

	<div class="col-sm-12" style="margin-top: 40px">
	    <div class="card card-stats">
	    	<div class="card-header" data-background-color="orange">
	    		<i class="material-icons">content_copy</i>
	    	</div>
			<div class="card-title"><h4>用户基金</h4></div>
	    	<div class="card-content">
				<?php
					$query = Share::find()->where(["user_id" => $model->user_id]);
					$dataProvider = new ActiveDataProvider(['query' => $query]);
					$dataProvider->setPagination(["pageSize" => 15]);

					echo $this->render('/share/index', [
						'dataProvider' => $dataProvider,
						'user_id' => $model->user_id,
					]);
				?>
	    	</div>
	    </div>
	</div>
</div>
