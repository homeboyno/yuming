<?php

namespace frontend\controllers;

use common\models\Edite;
// use frontend\filters\VisitStatistics;

class EditeController extends \yii\web\Controller {

	// public function behaviors() {
	// 	return [
	// 		VisitStatistics::className()
	// 	];
	// }

	public function actionView($type, $id) {
        $this->layout = 'edite';
		$model = $this->findModel($type, $id);

		return $this->render('view', [ "model" => $model ]);
	}

	protected function findModel($type, $id) {
		$types = [
			'edite' => '\common\models\Edite',
			'news' => '\common\models\News',
			'glory' => '\common\models\Glory',
		];
		if (isset($types[$type])) {
			$class = $types[$type];
			if (($model = $class::findOne($id)) !== null) {
				return $model;
			}	
		}

		throw new \yii\web\NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
	}
}
