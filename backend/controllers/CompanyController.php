<?php

namespace backend\controllers;

use common\models\Company;
use common\models\CompanySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller {

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
	 * Lists all Company models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new CompanySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->setPagination(["pageSize" => 15]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Company model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Company model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Company();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return \Yii::createObject([
				'class' => 'yii\web\Response',
				'format' => \yii\web\Response::FORMAT_JSON,
				'data' => [
					'message' => Yii::t('app', "Create Success!"),
					'success' => true,
					'data' => [
						'id' => $model->id],
				],
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Company model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return \Yii::createObject([
				'class' => 'yii\web\Response',
				'format' => \yii\web\Response::FORMAT_JSON,
				'data' => [
					'message' => Yii::t('app', "Update Success!"),
					'success' => true,
					'data' => [
						'id' => $model->id],
				],
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Company model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the Company model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Company the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Company::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
