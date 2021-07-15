<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "edite".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 */
class Edite extends \yii\db\ActiveRecord {
	const EDITE_ABOUT_USHINE = 1;
	const EDITE_TEST_ENVIRONEMENT = 2;
	const EDITE_CLIENT = 3;
	const EDITE_FONCTION = 4;

	const EDITE_HUMAN_TEST = 5;
	const EDITE_CONTACT_US = 6;
	// const EDITE_ABOUT_USHINEF = 1;
	// const EDITE_RISK_CONTROL = 2;
	// const EDITE_UNION = 3;
	// const EDITE_PARTY = 4;

	// const EDITE_FUND_CONDITION = 5;
	// const EDITE_FUND_PROCESS = 6;
	// const EDITE_FUND_MUST_KNOW = 7;
	// const EDITE_FUND_RISK_NOTIFY = 8;

	// const EDITE_REGISTER_CONTRACT = 9;
	// const EDITE_TALENT_CONSTRUCTION = 10;
	// const EDITE_REPORT = 11;
	// const COMPlIANCE_MANAGEMENT = 13;
	// const EDITE_NOTIFY = 14;

	public $imageFile;

	public static function tableName() {
		return 'edite';
	}

	// public function behaviors(){
	// 	return [ \nhkey\arh\ActiveRecordHistoryBehavior::className() ];
	// }

	public static function editeList() {
		return [
			self::EDITE_ABOUT_USHINE => Yii::t('app',"关于友山"),
			self::EDITE_TEST_ENVIRONEMENT => Yii::t('app',"考试环境"),
			self::EDITE_CLIENT => Yii::t('app',"客户评价"),

			self::EDITE_FONCTION => Yii::t('app',"培训业务"),
			self::EDITE_HUMAN_TEST => Yii::t('app',"人才评测"),

			self::EDITE_CONTACT_US => Yii::t('app',"联系我们"),
			// self::EDITE_ABOUT_USHINEF => Yii::t('app',"关于友山"),
			// self::EDITE_RISK_CONTROL => Yii::t('app',"风险控制"),
			// self::COMPlIANCE_MANAGEMENT => Yii::t('app',"合规管理"),

			// self::EDITE_UNION => Yii::t('app',"工会风采"),
			// self::EDITE_PARTY => Yii::t('app',"党建工作"),

			// self::EDITE_FUND_CONDITION => Yii::t('app',"认购条件"),
			// self::EDITE_FUND_PROCESS => Yii::t('app',"认购程序"),
			// self::EDITE_FUND_MUST_KNOW => Yii::t('app',"认购须知"),
			// self::EDITE_FUND_RISK_NOTIFY => Yii::t('app',"风险揭示"),

			// self::EDITE_REGISTER_CONTRACT => Yii::t('app',"注册协议"),
			// self::EDITE_TALENT_CONSTRUCTION => Yii::t('app',"人才建设"),
			// self::EDITE_REPORT => Yii::t('app',"策略报告"),
			// self::EDITE_NOTIFY => Yii::t('app',"通知公告"),
		];
	}

	public function scenarios() {
		return ['default' => ['content', 'title'], 'upload' => ['imageFile']];
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['title', 'content'], 'required'],
			[['content'], 'string'],
			[['title'], 'string', 'max' => 60],
			['imageFile', 'file', 'skipOnEmpty' => false, 'maxSize' => 1024 * 1024], // 1M
			['imageFile', 'image', 'skipOnEmpty' => false],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('app', 'ID'),
			'title' => Yii::t('app', '名称'),
			'content' => Yii::t('app', '内容'),
		];
	}

	public function upload() {
		$this->setScenario('upload');
		if ($this->validate()) {
			$filename = hash_file('md5', $this->imageFile->tempName);
			$filepath = \Yii::getAlias("@webroot") . "/../images/upload/" . $filename . '.' . $this->imageFile->extension;
			$this->imageFile->saveAs($filepath);
			return "/images/upload/" . $filename . '.' . $this->imageFile->extension;
		} else {
			return false;
		}
	}
}
