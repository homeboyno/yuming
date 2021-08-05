<?php
namespace frontend\controllers;

use common\models\Appointment;
use common\models\Edite;
use common\models\Executive;
use common\models\Fund;
use common\models\FundManager;
use common\models\Glory;
use common\models\LoginForm;
use common\models\PartyImage;
use common\models\RegisterForm;
use common\models\SMSForm;
use common\models\UnionImage;
use common\models\UpdatePwdForm;
use common\models\User;
use Yii;

use common\components\Instruction;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use frontend\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\filters\VisitStatistics;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use common\models\UserSearch;

class SiteController extends Controller {
	public $enableCsrfValidation = false;

	public function behaviors() {
		return [
			// VisitStatistics::className(),
			// 'access' => [
			// 	'class' => AccessControl::className(),
			// 	'only' => ['logout', 'appointment', 'share', 'update-password'],
			// 	'rules' => [
			// 		[
			// 			'actions' => ['logout', 'appointment', 'share', 'update-password'],
			// 			'allow' => true,
			// 			'roles' => ['@'],
			// 		],
			// 	],
			// ],
			// 'contentNegotiator' => [
			// 	'class' => \yii\filters\ContentNegotiator::className(),
			// 	'only' => ['is-risk-tested', 'logout', 'sms', 'phoneregister', 'islogin', 'reset-password', 'risk-test', 'reservation'],
			// 	'formatParam' => '_format',
			// 	'formats' => [
			// 		'application/json' => \yii\web\Response::FORMAT_JSON,
			// 	],
			// ],
		];
	}

	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
				'view' => '/site/error',
			],
	// 		'captcha' => [
	// 			'class' => 'yii\captcha\CaptchaAction',
	// 			'minLength' => 1,
	// 			'maxLength' => 5,
	// 			'backColor' => 0xFFFFFF,
	// 			'foreColor' => 0x080058,
	// 			'width' => 100,
	// 			'height' => 40,
	// 		],
			'test-environment' => [ // 开始环境
				'class' => '\frontend\components\EditeAction',
				'id' => Edite::EDITE_TEST_ENVIRONEMENT,
			],
			'client-evaluate' => [ // 客户评价
				'class' => '\frontend\components\EditeAction',
				'id' => Edite::EDITE_CLIENT,
			],
			'train-fonction' => [ // 培训业务
				'class' => '\frontend\components\EditeAction',
				'id' => Edite::EDITE_FONCTION,
			],
			'personnel-test' => [ // 人才测评
				'class' => '\frontend\components\EditeAction',
				'id' => Edite::EDITE_HUMAN_TEST,
			],
			'contact-us' => [ // 联系我们
				'class' => '\frontend\components\EditeAction',
				'id' => Edite::EDITE_CONTACT_US,
			]
		];
	}

	// public function beforeAction($action) {
	// 	$cookies = \Yii::$app->request->cookies;
	// 	// 获取名为 "language" cookie 的值，如果不存在，返回默认值 "zh-CN"
	// 	$language = $cookies->getValue('language', 'zh-CN');

	// 	\Yii::$app->language = $language;
	// 	return parent::beforeAction($action);
	// }

	// public function actionSetLanguage($language) {
	// 	$cookies = Yii::$app->response->cookies;
	// 	$cookies->add(new \yii\web\Cookie([
	// 	    'name' => 'language',
	// 	    'value' => $language,
	// 	]));
	// 	return $this->goBack();
	// }

	public function actionSetRead($id) {
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
				'name' => $id,
				'value' => true,
		]));
	}

	public function actionIndex() {
		// $this->layout = false;
		Yii::$app->view->params = [ 'Banner' => false, 'Sidebar' => false, 'Footer' => true ];
		return $this->render('index');
	}

	public function actionHistory() {
		$dataProvider = new ActiveDataProvider([
			'query' => Glory::find()->orderBy('createtime desc')->where(['isShow' => 1]),
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $this->render('history', ["dataProvider" => $dataProvider]);
	}

	public function actionHistoryDetail($id) {
		if (($model = Glory::findOne($id)) == null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		$before = (new \yii\db\Query())
			->from([Glory::tableName() . " n"])
			->where("id = (select max(id) from " . Glory::tableName() . " where id < :id and isShow = 1)",
				["id" => $id])->one();

		$after = (new \yii\db\Query())
			->from([Glory::tableName() . " n"])
			->where("id = (select min(id) from " . Glory::tableName() . " where id > :id and isShow = 1)",
				['id' => $id])->one();

		return $this->render('history-detail', [
			"model" => $model,
			"before" => $before,
			'after' => $after,
		]);
	}


	public function actionJiZhi() {
		return $this->render('JiZhi');
	}

	public function actionInterfation() {
		// Yii::$app->view->params = [ 'Banner' => false, 'Sidebar' => false, 'Footer' => false ];
		return $this->render('interfation');
	}

	public function actionXiQian() {
		return $this->render('XiQian');
	}

	// 关于友山
	public function actionAbout() {
		Yii::$app->view->params['Sidebar'] = false;
		Yii::$app->view->params['Banner'] = true;
		return $this->render('about');
	}

	public function actionExecutive() {
		$execs = Executive::find()->where(["isShow" => true])->orderBy(['weight' => SORT_DESC])->asArray()->all();

		$result = [];
		foreach ($execs as $exec) {
			$apartment = $exec["apartment"];
			if (!isset($result[$apartment])) $result[$apartment] = [];
			$result[$apartment][] = $exec;
		}

		foreach ($result as $key => $value) {
			ArrayHelper::multisort($result[$key], 'weigth', SORT_DESC);
		}

		return $this->render('executive', [
			'execs' => $result,
		]);
	}

	public function actionFundManager() {
		$values = new ActiveDataProvider([
			'query' => FundManager::find()->where(["isShow" => true])->orderBy('weight desc'),
			'pagination' => [
				'pageSize' => 99,
			],
		]);

		return $this->render('fund-manager', ['model' => $values]);
	}

	public function actionUnion() {
		$content = Edite::findOne(Edite::EDITE_UNION)->content;
		$images = UnionImage::find()->orderBy('rand()')->limit(4)->asArray()->all();
		return $this->render('party', [
			'content' => $content,
			'images' => $images,
		]);
	}

	public function actionParty() {
		$content = Edite::findOne(Edite::EDITE_PARTY)->content;
		$images = PartyImage::find()->orderBy('rand()')->limit(4)->asArray()->all();
		return $this->render('party', [
			'content' => $content,
			'images' => $images,
		]);
	}

	public function actionRegisterContract() {
		$content = Edite::findOne(Edite::EDITE_REGISTER_CONTRACT)->content;
		echo $content;
	}

	// public function actionUser($params=null) {
	// 	$searchModel = new UserSearch();
	// 	$dataProvider = $searchModel->search($params);
	// 	$totalCount = $dataProvider->getTotalCount();
	// 	$dataProvider->setPagination(["pageSize" => $totalCount]);

	// 	return $this->render('user', [
	// 		'searchModel' => $searchModel,
	// 		'dataProvider' => $dataProvider,
	// 	]);
	// }
}
