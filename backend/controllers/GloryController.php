<?php

namespace backend\controllers;

use common\models\Glory;
use common\models\GlorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;
use jackh\dashboard\HtmlProcess;

/**
 * GloryController implements the CRUD actions for Glory model.
 */
class GloryController extends Controller {

	public $layout = '@jackh/dashboard/views/layouts/partial.php';

	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
			'contentNegotiator' => [
				'class' => \yii\filters\ContentNegotiator::className(),
				'only' => ['upload', 'delete'],
				'formatParam' => '_format',
				'formats' => [
					'application/json' => \yii\web\Response::FORMAT_JSON,
				],
			],
		];
	}

	/**
	 * Lists all Glory models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new GlorySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->setPagination(["pageSize" => 15]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Glory model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Glory();
		if ($model->load(Yii::$app->request->post())) {
			$basePath = Yii::getAlias("@webroot") . "/..";
			$uploadPath = "$basePath/images/upload";
			$model->content = HtmlProcess::processHtmlImage($model->content, $uploadPath, $basePath);
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("refresh", [
					"data-target" => "#dashboard-list",
					"callback" => "console.log(111)"
				]);
				return $this->redirect(Url::to(['/glory/update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing Glory model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$basePath = Yii::getAlias("@webroot") . "/..";
			$uploadPath = "$basePath/images/upload";
			$model->content = HtmlProcess::processHtmlImage($model->content, $uploadPath, $basePath);
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Update Success!')]);
				Yii::$app->session->setFlash("refresh", ["data-target" => "#dashboard-list"]);
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Update Failed!')]);
			}
		}

		return $this->render('update', [ 'model' => $model ]);
	}

	public function actionUpload() {
		$model = new Glory;
		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$filepath = $model->upload();
			if ($filepath !== false) {
				// file is uploaded successfully
				return [
					'success' => true,
					'data' => [
						'url' => $filepath,
					],
				];
			}
		}
		return ["success" => false];
	}

	/**
	 * Deletes an existing Glory model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the Glory model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Glory the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Glory::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
