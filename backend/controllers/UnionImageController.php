<?php

namespace backend\controllers;

use common\models\UnionImage;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * UnionImageController implements the CRUD actions for UnionImage model.
 */
class UnionImageController extends Controller {

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
	 * Lists all UnionImage models.
	 * @return mixed
	 */
	public function actionIndex() {
		$dataProvider = new ActiveDataProvider([
			'query' => UnionImage::find(),
		]);

		return $this->render('index', ['dataProvider' => $dataProvider]);
	}

	public function actionCreate() {
		$model = new UnionImage();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#UnionImageContainer",
					"reloadUrl" => Url::to(["union-image/index"])
				]);
				Yii::$app->session->setFlash("modal-close");
				return $this->redirect(Url::to(['/union-image/update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}
	/**
	 * Updates an existing UnionImage model.
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
					"pjaxContainer" => "#UnionImageContainer",
					"reloadUrl" => Url::to(["index"])
				]);
				Yii::$app->session->setFlash("modal-close");
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Update Failed!')]);
			}
		}

		return $this->render('update', ['model' => $model]);
	}

	public function actionUpload() {
		$model = new UnionImage;
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
	 * Deletes an existing UnionImage model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the UnionImage model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return UnionImage the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = UnionImage::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
