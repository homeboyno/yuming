<?php

namespace backend\controllers;

use common\models\Share;
use common\models\ShareSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * ShareController implements the CRUD actions for Share model.
 */
class ShareController extends Controller {

	public $layout = '@jackh/dashboard/views/layouts/partial.php';

	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Share models.
	 * @return mixed
	 */
	public function actionIndex($user_id) {
		$searchModel = new ShareSearch();
		$dataProvider = $searchModel->search(["ShareSearch" => ["user_id" => $user_id]]);
		$dataProvider->setPagination(["pageSize" => 15]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'user_id' => $user_id,
		]);
	}

	/**
	 * Creates a new Share model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($user_id) {
		$model = new Share();
		$model->user_id = $user_id;
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			Yii::$app->db->createCommand()->insert('share', [
				'fund_id' => $model->fund_id,
				'user_id' => $model->user_id,
				'share' => $model->share,
			])->execute();
			Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
			Yii::$app->session->setFlash("modal-close");
			Yii::$app->session->setFlash("pjax-reload", [
				"target" => "#dashboard-content",
				"pjaxContainer" => "#ShareContainer",
				"reloadUrl" => Url::to(["index", "user_id" => $user_id])
			]);
		}

		return $this->render('create', [ 'model' => $model ]);
	}

	/**
	 * Updates an existing Share model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $fund_id
	 * @param string $user_id
	 * @param integer $fund_type
	 * @return mixed
	 */
	public function actionUpdate($fund_id, $user_id) {
		$model = $this->findModel($fund_id, $user_id);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			Yii::$app->db->createCommand()->update('share', [
				'share' => $model->share,
			], [
				'fund_id' => $model->fund_id,
				'user_id' => $model->user_id
			])->execute();
			Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
			Yii::$app->session->setFlash("modal-close");
			Yii::$app->session->setFlash("pjax-reload", [
				"target" => "#dashboard-content",
				"pjaxContainer" => "#ShareContainer",
				"reloadUrl" => Url::to(["index", "user_id" => $user_id])
			]);
		}

		return $this->render('update', [ 'model' => $model ]);
	}

	/**
	 * Deletes an existing Share model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $fund_id
	 * @param string $user_id
	 * @param integer $fund_type
	 * @return mixed
	 */
	public function actionDelete($fund_id, $user_id) {
		$model = $this->findModel($fund_id, $user_id);
		Yii::$app->db->createCommand()->delete('share', [
			'fund_id' => $fund_id,
			'user_id' => $user_id
		])->execute();
	}

	/**
	 * Finds the Share model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $fund_id
	 * @param string $user_id
	 * @param integer $fund_type
	 * @return Share the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($fund_id, $user_id) {
		$model = Share::find()->where(['fund_id' => $fund_id, 'user_id' => $user_id])->one();
		if ($model !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
