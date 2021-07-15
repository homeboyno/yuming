<?php

namespace backend\controllers;

use common\models\Edite;
use common\models\EditeSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;
use jackh\dashboard\HtmlProcess;

/**
 * EditeController implements the CRUD actions for Edite model.
 */
class EditeController extends Controller {

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
	 * Lists all Edite models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new EditeSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->setPagination(["pageSize" => 15]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Edite model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Edite();

		if ($model->load(Yii::$app->request->post())) {
			$basePath = Yii::getAlias("@webroot") . "/..";
			$uploadPath = "$basePath/images/upload";
			$model->content = HtmlProcess::processHtmlImage($model->content, $uploadPath, $basePath);
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("refresh", ["data-target" => "#dashboard-list"]);
				return $this->redirect(Url::to(['/edite/update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing Edite model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		// if (in_array($model->id, [Edite::EDITE_UNION, Edite::EDITE_PARTY])) {
		// 	if (!\Yii::$app->user->can('党建工会编辑权限')) {
		// 		throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		// 	}
		// }
		// if (in_array($model->id, [Edite::EDITE_ABOUT_USHINEF, Edite::EDITE_RISK_CONTROL])) {
		// 	if (!\Yii::$app->user->can('关于合规编辑权限')) {
		// 		throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		// 	}
		// }
		// if (in_array($model->id, [
		// 		Edite::EDITE_FUND_CONDITION,
		// 		Edite::EDITE_FUND_PROCESS,
		// 		Edite::EDITE_FUND_MUST_KNOW,
		// 		Edite::EDITE_FUND_RISK_NOTIFY
		// 	])) {
		// 	if (!\Yii::$app->user->can('认购须知编辑权限')) {
		// 		throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		// 	}
		// }
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
		$model = new Edite;
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
	 * Deletes an existing Edite model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the Edite model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Edite the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Edite::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
