<?php

namespace backend\controllers;

use common\models\User;
use common\models\UserSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

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
	 * Lists all User models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel = new UserSearch();
		$params = Yii::$app->request->queryParams;
		$dataProvider = $searchModel->search($params);
		$dataProvider->setPagination(["pageSize" => 15]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionSearch() {
		$model = new UserSearch();
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			Yii::$app->session->setFlash("modal-close");
			Yii::$app->session->setFlash("pjax-reload", [
                "target" => "#dashboard-list",
                "pjaxContainer" => "#UserContainer",
                "reloadUrl" => Url::to(array_merge(["index"], $post))
            ]);
		}
		return $this->render('_search', ["model" => $model]);
	}

	/**
	 * Creates a new User model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new User();
		if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
			try{
				$model->user_id = hash('md5', rand() + time());
				if ($model->save()) {
					Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
					Yii::$app->session->setFlash("refresh", ["data-target" => "#dashboard-list"]);
					$transaction->commit();
					return $this->redirect(Url::to(['/user/update', "id" => $model->user_id]));
				} else {
					throw new \Exception;
				}
			
			}catch(\Exception $e) {
				$transaction->rollback();
				$firstError = "Create Failed!";
                foreach ($model->firstErrors as $key => $value) {
                    $firstError = $value;
                }
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', $firstError)]);

			}
		}
		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing User model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
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
	 * Deletes an existing User model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
	}

	/**
	 * Finds the User model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return User the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = User::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
