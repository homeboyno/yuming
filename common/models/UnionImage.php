<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unionimage".
 *
 * @property integer $id
 * @property integer $bid
 * @property string $url
 */
class UnionImage extends \yii\db\ActiveRecord {
	public $imageFile;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'unionimage';
	}

	public function scenarios() {
		return ['default' => ['url', 'info'], 'upload' => ['imageFile']];
	}

	// public function behaviors(){
	// 	return [ \nhkey\arh\ActiveRecordHistoryBehavior::className() ];
	// }

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['url'], 'required'],
			[['url'], 'string'],
			['info', 'string', 'max' => 256],
			[
				['imageFile'],
				'file',
				'skipOnEmpty' => true,
				'extensions' => 'png, jpg, jpeg',
				'mimeTypes' => 'image/jpeg, image/png, image/jpg',
				'maxSize' => 512000,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('app', 'ID'),
			'url' => Yii::t('app', 'Url'),
			'info' => '描述',
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
