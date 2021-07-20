<?php
namespace common\models;

use Yii;
use common\models\Share;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "User".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 */
class User extends ActiveRecord implements IdentityInterface {
	const TYPE_USER = 0;
	const TYPE_ORGANIZATION = 1;
	const TYPE_ROOT = 2;
	const TYPE_BACKEND = 3;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'user';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			// [['phone', 'username', 'certificate_type', 'certificate'], 'required'],
			[['phone', 'username'], 'required'],
			['user_id', 'string', 'length' => 32],
			[['username', 'password', 'email'], 'string', 'max' => 64],
			['phone', 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]\d{4,8}$/'],
			[['authKey', 'accessToken'], 'string', 'max' => 80],
			['salt', 'string', 'length' => 5],
			['is_active', 'boolean'],
			[['riskscore'], 'number', 'min' => 8, 'integerOnly' => true],
			[['agreecontract'], 'boolean'],
			[['type'], 'number', 'min' => 0],
			['address', 'string', 'length' => [0, 256]],
			// ['certificate_type', 'match', 'pattern' => '/^\d{3}$/'],
			['email', 'match', 'pattern' => '/^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/i', 'when' => function ($model) {
				return strlen($model->email) != 0;
			}, 'message' => "邮箱格式不合法"],
			// ['certificate', 'string', 'length' => [0, 32]],
			['phone', 'unique']
		];
	}

	// public function scenarios() {
	// 	return [
	// 		'default' => [
	// 			'user_id',
	// 			'username',
	// 			'password',
	// 			'salt',
	// 			'authKey',
	// 			'accessToken',
	// 			'phone',
	// 			'email',
	// 			'riskscore',
	// 			'agreecontract',
	// 			'type',
	// 			'certificate_type',
	// 			'certificate',
	// 			'address',
	// 			'is_active'
	// 		],
	// 		'updateInfo' => [
	// 			'address',
	// 			'email',
	// 		],
	// 	];
	// }

	// public static function certificateType() {
	// 	return [
	// 		"001" => "身份证",
	// 		"002" => "护照",
	// 		"003" => "港澳通行证",
	// 		"101" => "组织机构代码证件",
	// 		"102" => "营业执照注册号",
	// 		"103" => "三证合一代码",
	// 	];
	// }

	// public static function userType() {
	// 	return [
	// 		static::TYPE_USER => "个人用户",
	// 		static::TYPE_ORGANIZATION => "组织用户",
	// 		static::TYPE_ROOT => "超级用户"
	// 	];
	// }

	// public static function userRegisterType() {
	// 	return [
	// 		static::TYPE_USER => "个人用户",
	// 		static::TYPE_ORGANIZATION => "组织用户"
	// 	];
	// }

	// public static function RiskType($score) {
	// 	if (empty($score) || $score == 0) {
	// 		return -1;
	// 	}
	// 	if ($score <= 20) {
	// 		return 0;
	// 	} else if ($score >= 21 && $score <= 40) {
	// 		return 1;
	// 	} else if ($score >= 41 && $score <= 60) {
	// 		return 2;
	// 	} else if ($score >= 61 && $score <= 80) {
	// 		return 3;
	// 	} else {
	// 		return 4;
	// 	}
	// }

	// public function getRiskType() {
	// 	if (empty($this->riskscore) || $this->riskscore == 0) {
	// 		return -1;
	// 	}
	// 	if ($this->riskscore <= 20) {
	// 		return 0;
	// 	} else if ($this->riskscore >= 21 && $this->riskscore <= 40) {
	// 		return 1;
	// 	} else if ($this->riskscore >= 41 && $this->riskscore <= 60) {
	// 		return 2;
	// 	} else if ($this->riskscore >= 61 && $this->riskscore <= 80) {
	// 		return 3;
	// 	} else {
	// 		return 4;
	// 	}
	// }

	// public function hasShare($fund) {
	// 	if (!($fund instanceof \common\models\Fund)) throw new \Exception("必须是Fund实例才可以调用此函数");
	// 	$share = $this->share;
	// 	$share = ArrayHelper::toArray($share);
	// 	$share = ArrayHelper::index($share, 'fund_id');
	// 	return isset($share[$fund->id]);
	// }

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'user_id' => 'ID',
			'username' => '用户名',
			'password' => '密码',
			'salt' => 'Salt',
			'authKey' => 'Auth Key',
			'accessToken' => 'Access Token',
			'phone' => '电话',
			'email' => '邮箱',
			'riskscore' => '风险测试分数',
			'agreecontract' => '同意用户投资协议',
			'type' => '用户类型',
			'certificate_type' => '证件类型',
			'certificate' => '证件号码',
			'address' => '地址',
			'is_active' => '是否激活'
		];
	}
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return static::findOne($id);
	}
	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		return static::findOne(['access_token' => $token]);
	}
	/**
	 * Finds user by email
	 *
	 * @param  string      $email
	 * @return static|null
	 */
	public static function findByEmail($email) {
		return static::findOne(['email' => $email]);
	}

	/**
	 * Finds user by phonenumber
	 *
	 * @param  string      $phonenumber
	 * @return static|null
	 */
	public static function findByPhone($phone) {
		return static::findOne(['phone' => $phone]);
	}

	/**
	 * Finds user by certificate
	 *
	 * @param  string      $certificate
	 * @return static|null
	 */
	public static function findByCertificate($id) {
		return static::findOne(['certificate' => $id]);
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->user_id;
	}
	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return $this->authKey;
	}

	public function getShare() {
		return $this->hasMany(Share::className(), ["user_id" => "user_id"]);
	}
	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey) {
		return $this->getAuthKey() === $authKey;
	}
	/**
	 * Validates password
	 *
	 * @param  string  $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password) {
		// 使用yii2自带的hash加密，并验证
		// $encryptPassword = Yii::$app->getSecurity()->generatePasswordHash($password);
		// $encryptPassword = hash('md5', $this->salt . $password);
		// return $this->password === $encryptPassword;
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}

	// public static function LoginErrorTooMuch($token) {
	// 	return \Yii::$app->redis->get($token) >= 2;
	// }

	// public function fields() {
	// 	return [
	// 		'用户名' => 'username',
    //         "电话" => 'phone',
    //         "证件类型" => function() {
	// 			return self::certificateType()[$this->certificate_type];
	// 		},
	// 		'证件号码' => 'certificate'
	// 	];
	// }
}
