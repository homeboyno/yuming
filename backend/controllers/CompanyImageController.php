<?php

namespace backend\controllers;

use common\models\CompanyImage;
use common\models\CompanyImageSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * CompanyImageController implements the CRUD actions for CompanyImage model.
 */
class CompanyImageController extends Controller {

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
				'only' => ['upload'],
				'formatParam' => '_format',
				'formats' => [
					'application/json' => \yii\web\Response::FORMAT_JSON,
				],
			],
		];
	}

	/**
	 * Lists all CompanyImage models.
	 * @return mixed
	 */
	public function actionIndex($cid) {
		$searchModel = new CompanyImageSearch();
		$dataProvider = $searchModel->search(["CompanyImageSearch" => ["cid" => $cid]]);
		$dataProvider->setPagination(["pageSize" => 4]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'cid' => $cid,
		]);
	}

	/**
	 * Creates a new CompanyImage model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($cid) {
		$model = new CompanyImage();
		$model->setAttributes(['cid' => $cid]);

		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#CompanyImageContainer",
					"reloadUrl" => Url::to(["company-image/index", "cid" => $model->cid])
				]);
				Yii::$app->session->setFlash("modal-close");
				return $this->redirect(Url::to(['update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model,
			'cid' => $cid,
		]);
	}

	/**
	 * Updates an existing CompanyImage model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Update Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#CompanyImageContainer",
					"reloadUrl" => Url::to(["company-image/index", "cid" => $model->cid])
				]);
				Yii::$app->session->setFlash("modal-close");
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Update Failed!')]);
			}
		}

		return $this->render('update', ['model' => $model]);
	}

	public function actionUpload($cid) {
		$model = new CompanyImage;
		if (Yii::$app->request->isPost) {
			$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
			$filepath = $model->upload();
			if ($filepath !== false) {
				// file is uploaded successfully
				$model->setScenario('default');
				$model->setAttributes([
					"cid" => (int) $cid,
					"url" => $filepath,
				]);
				$model->save();
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
	 * Deletes an existing CompanyImage model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the CompanyImage model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CompanyImage the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = CompanyImage::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
