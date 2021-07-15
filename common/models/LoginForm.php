<?php
namespace common\models;

use common\components\RedisTable;
use yii\base\Model;
use \Yii;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model {
	public $token;
	public $password;
	public $captcha;
	private $_user = false;
	/**
	 * @return array the validation rules.
	 */
	public function rules() {
		return [
			// token and password are both required
			[['token', 'password'], 'required'],
			// ['token', 'match', 'pattern' => '/^1\d{10}$/', 'message' => '电话号码格式错误。'],
			// ['token', 'validateToken'],
			// [
			// 	'captcha',
			// 	'required',
			// 	'message' => '请输入验证码',
			// 	'when' => function ($model) {
			// 		$redis = Yii::$app->redis;
			// 		$redis->select(RedisTable::USER_LOGIN_WRONG);
			// 		return $redis->get($model->token) >= 2;
			// 	}
			// ],
			// [
			// 	'captcha',
			// 	'captcha',
			// 	'captchaAction' => '/site/captcha',
			// 	'caseSensitive' => false,
			// 	'message' => '验证码错误',
			// 	'when' => function ($model) {
			// 		Yii::$app->redis->select(RedisTable::USER_LOGIN_WRONG);
			// 		return Yii::$app->redis->get($model->token) >= 2;
			// 	}
			// ],
			// password is validated by validatePassword()
			['password', 'validatePassword'],
		];
	}

	

	// public function behaviors(){
	// 	return [ \nhkey\arh\ActiveRecordHistoryBehavior::className() ];
	// }

	public function attributeLabels() {
		return [
			'token' => '手机号码/身份证号码',
			// 'captcha' => '验证码',
			'password' => '密码',
		];
	}
	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validatePassword($attribute, $params) {
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if ($user && !$user->validatePassword($this->password)) {
				if (Yii::$app->redis->get($this->token) != null) {
					Yii::$app->redis->incr($this->token);
				} else {
					Yii::$app->redis->setex($this->token, 24 * 60 * 60, 1);
				}
			}
			if (!$user || !$user->validatePassword($this->password)) {
				$this->addError($attribute, '用户名或密码错误');
			}
		}
	}

	public function validateToken($attribute, $params) {
		if (!$this->hasErrors()) {
			$array = ['/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X|x)$/', '/^1[45][0-9]{7}|G[0-9]{8}|P[0-9]{7}|S[0-9]{7,8}|D[0-9]+$/', '/^[HMhm]{1}([0-9]{10}|[0-9]{8})$/', '/^([0-9a-z]){8}-[0-9|x]$/', '/^1\d{10}$/'];
			foreach ($array as $key => $value) {
				if(preg_match($value,$this->token)) return true;
				else continue;  
			}
			$this->addError($attribute, "手机或者证件号码的格式错误");
		}
	}
	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login() {
		$user = $this->getUser();
		if (!$user) {
			return false;
		}
		// if ($type != null) {
		// 	if (is_int($type) && $user->type != $type) {
		// 		return false;
		// 	}
		// 	if (is_array($type) && !in_array($user->type, $type)) {
		// 		return false;
		// 	}
		// }
		// 删除密码错误记录
		Yii::$app->redis->del($this->token);
		return Yii::$app->user->login($this->getUser(), 3600 * 4);
	}
	/**
	 * Finds user by [[username]]
	 *
	 * @return User|null
	 */
	public function getUser() {
		if ($this->_user === false) {
			$this->_user = User::findByPhone($this->token) != null ? User::findByPhone($this->token) : User::findByCertificate($this->token);
		}
		return $this->_user;
	}
}
