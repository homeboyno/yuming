<?php

namespace backend\controllers;

use common\models\FundAbstract;
use common\models\FundAbstractSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * FundAbstractController implements the CRUD actions for FundAbstract model.
 */
class FundAbstractController extends Controller {

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
	 * Lists all FundAbstract models.
	 * @return mixed
	 */
	public function actionIndex($fund_id) {
		$searchModel = new FundAbstractSearch();
		$dataProvider = $searchModel->search(["FundAbstractSearch" => ["fund_id" => $fund_id]]);
		$dataProvider->setPagination(["pageSize" => 5]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'fund_id' => $fund_id,
		]);
	}

	/**
	 * Creates a new FundAbstract model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($fund_id) {
		$model = new FundAbstract();
		$model->fund_id = $fund_id;
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#FundAbstractContainer",
					"reloadUrl" => Url::to(["fund-abstract/index", "fund_id" => $fund_id])
				]);
				Yii::$app->session->setFlash("modal-close");
				return $this->redirect(Url::to(['/fund-abstract/update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing FundAbstract model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#FundAbstractContainer",
					"reloadUrl" => Url::to(["fund-abstract/index", "fund_id" => $model->fund_id])
				]);
				Yii::$app->session->setFlash("modal-close");
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Update Success!')]);
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Update Failed!')]);
			}
		}

		return $this->render('update', [ 'model' => $model ]);
	}

	/**
	 * Deletes an existing FundAbstract model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the FundAbstract model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return FundAbstract the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = FundAbstract::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
