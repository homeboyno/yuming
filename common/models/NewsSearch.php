<?php

namespace common\models;

use common\models\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsSearch represents the model behind the search form about `app\models\News`.
 */
class NewsSearch extends News {
	/**
	 * @inheritdoc
	 */
	public $searched = false;

	public function rules() {
		return [
			[['id', 'type'], 'integer'],
			[['title', 'content', 'createtime'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$this->load($params);
		$query = News::find()->orderBy('createtime desc');
		if ($this->type !== null) {
			$query->where(['type' => $this->type]);
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		unset($params["NewsSearch"]["type"]);
		unset($params["page"]);
		unset($params["per-page"]);

		if (count($params["NewsSearch"]) != 0) {
			$this->searched = true;
		}

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		$query->andFilterWhere(['createtime' => $this->createtime])
			->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'content', $this->content]);

		return $dataProvider;
	}
}
