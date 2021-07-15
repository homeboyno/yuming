<?php

namespace backend\controllers;

use common\models\News;
use common\models\NewsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use jackh\dashboard\HtmlProcess;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller {

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
	 * Lists all News models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new NewsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->setPagination(["pageSize" => 15]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'type' => $searchModel->type,
		]);
	}

	/**
	 * Displays a single News model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new News model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($type) {
		$model = new News();
		$model->type = $type;

		if ($model->load(Yii::$app->request->post())) {
			$basePath = Yii::getAlias("@webroot") . "/..";
			$uploadPath = "$basePath/images/upload";
			$model->content = HtmlProcess::processHtmlImage($model->content, $uploadPath, $basePath);
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("refresh", ["data-target" => "#dashboard-list"]);
				return $this->redirect(Url::to(['/news/update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing News model.
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

	/**
	 * Deletes an existing News model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	public function actionUpload() {
		$model = new News;
		// $model = $this->findModel($id);
		// echo $model->id;
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

	public function actionUploadFiles() {
		$model = new News;
		$model->setScenario('uploadFile');
		if(Yii::$app->request->isAjax) {
			$model->file = UploadedFile::getInstanceByname('file');
			$filepath = $model->uploadFile();
            Yii::$app->response->format = 'json';
            return [ 
				'success' => true ,
                'data' =>[
					'filepath' => $filepath, 
					'filename' => $model->file->name
				],
            ];
		}
		else return ['success' => false];
	}

	/**
	 * Finds the News model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return News the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = News::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
