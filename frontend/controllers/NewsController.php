<?php

namespace frontend\controllers;

use common\models\Edite;
use common\models\News;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use frontend\filters\VisitStatistics;

class NewsController extends \yii\web\Controller {
	// public function behaviors() {
	// 	return [
	// 		VisitStatistics::className()
	// 	];
	// }

	public function beforeAction($action) {
		$cookies = \Yii::$app->request->cookies;
		// 获取名为 "language" cookie 的值，如果不存在，返回默认值 "zh-CN"
		$language = $cookies->getValue('language', 'zh-CN');

		\Yii::$app->language = $language;
		return parent::beforeAction($action);
	}

	public function actionIndex() {
		\Yii::$app->view->params['Sidebar'] = false;
		$dataProvider = new ActiveDataProvider([
			'query' => News::find()->where(["isShow" => 1])->orderBy('createtime desc'),
			'pagination' => [
				'pageSize' => 12,
			],
		]);

		return $this->render('index', [
			"dataProvider" => $dataProvider,
		]);
	}

	public function actionDetail($id) {
		$news = $this->findModel($id);
		$before = (new \yii\db\Query())
			->from([News::tableName() . " n"])
			->where("id = (select max(id) from " . News::tableName() . " where id < :id and isShow = 1)",
				["id" => $id])->one();

		$after = (new \yii\db\Query())
			->from([News::tableName() . " n"])
			->where("id = (select min(id) from " . News::tableName() . " where id > :id and isShow = 1)",
				['id' => $id])->one();

		return $this->render('detail', [
			"news" => $news,
			"before" => $before,
			'after' => $after,
		]);
	}

	protected function findModel($id) {
		if (($model = News::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionReport() {
		$content = Edite::findOne(Edite::EDITE_REPORT)->content;
		$name = Edite::editeList()[Edite::EDITE_REPORT];
		return $this->render('simpleEditionWithoutWrapper', [
			'content' => $content,
			'name' => $name,
		]);
	}
}
