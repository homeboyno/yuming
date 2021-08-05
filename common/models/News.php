<?php
//获取新闻列表
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "News".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $isShow
 * @property string $createtime
 * @property integer $type
 */
class News extends ActiveRecord {
	const NEWS_COMPANY_NEWS = 0;
	const NEWS_COMPANY_VIEWS = 1;
	const NEWS_COMPANY_NOTIFYS = 2;
	const NEWS_COMPANY_RECOMMAND = 3;

	const NEWS_FUND_NEWS = 4;

	const NEWS_REPORT = 5;
	const NEWS_RESEARCH = 6;


	public $imageFile;
	public $file;

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'news';
	}

	// public function behaviors(){
	// 	return [ \nhkey\arh\ActiveRecordHistoryBehavior::className() ];
	// }

	public static function typeToUrl() {
		return [
			Yii::t('app',"公司新闻") => Url::to(["/news/index", "type" => News::NEWS_COMPANY_NEWS]),
			Yii::t('app',"友山观点") => Url::to(["/news/index", "type" => News::NEWS_COMPANY_VIEWS]),
			Yii::t('app',"公司公告") => Url::to(["/news/index", "type" => News::NEWS_COMPANY_NOTIFYS]),
			// "友山荐文" => Url::to(["/news/index", "type" => News::NEWS_COMPANY_RECOMMAND]),
			// Yii::t('app',"策略报告") => Url::to(["/news/index", "type" => News::NEWS_REPORT]),
			Yii::t('app',"友山视角") => Url::to(["/news/index", "type" => News::NEWS_RESEARCH]),
		];
	}

	public function scenarios() {
		return ['default' => ['content', 'type', 'isShow', 'title', "fund_id", "createtime"], 'upload' => ['imageFile'], 'uploadFile' => ['file']];
	}
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['title', 'content', 'createtime'], 'required'],
			['content', 'string'],
			['type', 'integer'],
			['isShow', 'default', 'value' => "0"],
			['isShow', 'integer'],
			['title', 'string', 'max' => 60],
			['imageFile', 'file', 'skipOnEmpty' => false, 'maxSize' => 1024 * 1024], // 1M
			['imageFile', 'image', 'skipOnEmpty' => false],
			['file', 'file', 'skipOnEmpty' => false, 'maxSize' => 5 * 1024 * 1024, 'extensions' => ['pdf']],
		];
	}
	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('app','ID'),
			'title' => Yii::t('app','新闻标题'),
			'content' => Yii::t('app','内容'),
			'isShow' => Yii::t('app','是否展示'),
			'createtime' => Yii::t('app','创建时间'),
			'type' => Yii::t('app','新闻类型'),
			'fund_id' => Yii::t('app','绑定基金'),
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

	public function uploadFile() {
		$this->setScenario('uploadFile');
		if ($this->validate()) {
			$filename = hash_file('md5', $this->file->tempName);
			$filepath = \Yii::getAlias("@webroot") . "/../file/news/" . $filename . '.' . $this->file->extension;
			$this->file->saveAs($filepath);
			return $filepath;
		} else {
			return false;
		}
	}

	public static function getNewsByType($type) {
		return static::find()
			->where(["type" => $type, "isShow" => 1])
			->orderBy("createtime desc");
	}

	public function fields() {
		return [
			'title',
            "content" => function() {
				return strip_tags($this->content);
			},
            "createtime",
		];
	}
}
