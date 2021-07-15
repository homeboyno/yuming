<?php

namespace backend\controllers;

use common\models\FundManager;
use common\models\FundManagerRelation;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * FundManagerRelationController implements the CRUD actions for FundManagerRelation model.
 */
class FundManagerRelationController extends Controller {

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
	 * Lists all FundManagerRelation models.
	 * @return mixed
	 */
	public function actionIndex($fid) {
		$query = FundManagerRelation::find()->where(["fid" => $fid]);
		$dataProvider = new ActiveDataProvider(['query' => $query]);
		$dataProvider->setPagination(["pageSize" => 20]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'fid' => $fid,
		]);
	}

	/**
	 * Updates an existing FundManagerRelation model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $fid
	 * @param integer $mid
	 * @return mixed
	 */
	public function actionUpdate($fid) {
		if (!preg_match('/\d+/', $fid)) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		$post = Yii::$app->request->post();
		if ($post != NULl) {
			$choosenManager = [];
			if (!empty($post['FundManager'])) {
				$connection = Yii::$app->db;
				$connection->createCommand()->delete(FundManagerRelation::tableName(), 'fid = :fid', [':fid' => $fid])->execute();
				foreach ($post['FundManager'] as $key => $value) {
					if ($value["choosen"] == 1) {
						$choosenManager[] = [(int) $fid, $key];
					}
				}
				$connection->createCommand()->batchInsert(FundManagerRelation::tableName(), ["fid", "mid"], $choosenManager)->execute();
			}
			Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Update Success!')]);
			Yii::$app->session->setFlash("pjax-reload", [
				"target" => "#dashboard-content",
				"pjaxContainer" => "#FMRContainer",
				"reloadUrl" => Url::to(["fund-manager-relation/index", "fid" => $fid])
			]);
			Yii::$app->session->setFlash("modal-close");
			$relations = FundManager::find()->indexBy('id')->all();
			return $this->render('update', [
				'relations' => $relations,
				'fid' => $fid,
			]);
		} else {
			$relations = FundManager::find()->indexBy('id')->all();
			return $this->render('update', [
				'relations' => $relations,
				'fid' => $fid,
			]);
		}
	}

	/**
	 * Deletes an existing FundManagerRelation model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $fid
	 * @param integer $mid
	 * @return mixed
	 */
	public function actionDelete($fid, $mid) {
		$this->findModel($fid, $mid)->delete();
	}

	/**
	 * Finds the FundManagerRelation model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $fid
	 * @param integer $mid
	 * @return FundManagerRelation the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($fid, $mid) {
		if (($model = FundManagerRelation::findOne(['fid' => $fid, 'mid' => $mid])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
