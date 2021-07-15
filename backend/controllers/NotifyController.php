<?php

namespace backend\controllers;

use common\models\Notify;
use common\models\NotifySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use jackh\dashboard\HtmlProcess;
use yii\helpers\Url;

/**
 * NotifyController implements the CRUD actions for Notify model.
 */
class NotifyController extends Controller {

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
				'only' => ['image-upload', 'file-upload'],
				'formatParam' => '_format',
				'formats' => [
					'application/json' => \yii\web\Response::FORMAT_JSON,
				],
			],
		];
	}

	/**
	 * Lists all Notify models.
	 * @return mixed
	 */
	public function actionIndex($fid) {
		$searchModel = new NotifySearch();
		$dataProvider = $searchModel->search(["NotifySearch" => ["fund_id" => $fid]]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'fid' => $fid,
		]);
	}

	/**
	 * Creates a new Notify model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($fid, $download) {
		$model = new Notify();
		$model->fund_id = $fid;
		$model->download = $download;

		if ($model->load(Yii::$app->request->post())) {
			$basePath = Yii::getAlias("@webroot") . "/..";
			$uploadPath = "$basePath/images/upload";
			$model->content = HtmlProcess::processHtmlImage($model->content, $uploadPath, $basePath);
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#NotifyContainer",
					"reloadUrl" => Url::to(["notify/index", "fid" => $fid])
				]);
				Yii::$app->session->setFlash("modal-close");
				return $this->redirect(Url::to(['update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing Notify model.
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
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#NotifyContainer",
					"reloadUrl" => Url::to(["notify/index", "fid" => $id])
				]);
				Yii::$app->session->setFlash("modal-close");
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Update Failed!')]);
			}
		}

		return $this->render('update', [ 'model' => $model ]);
	}

	public function actionImageUpload() {
		$model = new Notify;
		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$filepath = $model->imageUpload();
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

	public function actionFileUpload() {
		$model = new Notify;
		if (Yii::$app->request->isPost) {
			$model->file = UploadedFile::getInstance($model, 'file');
			// var_dump($model->file);
			$filepath = $model->fileUpload();
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
	 * Deletes an existing Notify model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the Notify model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Notify the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Notify::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
