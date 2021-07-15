<?php
namespace backend\controllers;

use common\models\LoginForm;
use common\models\UpdatePwdForm;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['login', 'logout', 'error'],
				'rules' => [
					[
						'actions' => ['login', 'error'],
						'allow' => true,
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'minLength' => 1,
				'maxLength' => 5,
				'backColor' => 0xFFFFFF,
				'width' => 100,
				'height' => 40,
			],
		];
	}

	public function actionIndex() {
		if (!Yii::$app->user->isGuest && Yii::$app->user->identity->type == User::TYPE_BACKEND) {
			// exit;
			return $this->redirect('/dashboard/dashboard'); 
		} else {
			return $this->redirect('/dashboard/site/login');
		}
		// return true;
	}

	public function actionLogin() {
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		// exit;
		$post = Yii::$app->request->post();
		$model = new LoginForm();
		if ($model->load($post) && $model->validate() && $model->login(User::TYPE_BACKEND)) {
			return $this->redirect('/dashboard/dashboard');
		} else {
			$model->load(Yii::$app->request->post());
			$model->password = "";
			return $this->render('login', [
				'model' => $model,
			]);
		}
		// return true;
	}

	public function actionUpdatePassword() {
		// UpdatePassword是用户登录情况下
		$model = new UpdatePwdForm;
		$model->setScenario('updateAfterLogin');
		if (Yii::$app->request->isPost &&
			$model->load(Yii::$app->request->post()) &&
			$model->validate()) {
			return \Yii::createObject([
				'class' => 'yii\web\Response',
				'format' => \yii\web\Response::FORMAT_JSON,
				'data' => ['success' => $model->updateAfterLogin()],
			]);
		}
		return $this->render('updatePassword', ['model' => $model]);
	}

	public function actionLogout() {
		Yii::$app->user->logout();

		return $this->goHome();
	}
}