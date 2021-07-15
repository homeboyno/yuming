<?php

namespace backend\controllers;

use common\models\Fund;
use common\models\FundValue;
use common\models\FundValueSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * FundValueController implements the CRUD actions for FundValue model.
 */
class FundValueController extends Controller {
	public $layout = '@jackh/dashboard/views/layouts/partial.php';

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all FundValue models.
	 * @return mixed
	 */
	public function actionIndex($fid) {
		$searchModel = new FundValueSearch();
		$dataProvider = $searchModel->search(["FundValueSearch" => ["fid" => $fid]]);
		$dataProvider->setPagination(["pageSize" => 10]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'fid' => $fid,
		]);
	}

	/**
	 * Creates a new FundValue model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($fid) {
		$model = new FundValue();
		$model->fid = $fid;
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Create Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#FundValueContainer",
					"reloadUrl" => Url::to(["fund-value/index", "fid" => $fid])
				]);
				Yii::$app->session->setFlash("modal-close");
				return $this->redirect(Url::to(['/fund-value/update', "id" => $model->id]));
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Create Failed!')]);
			}
		}

		return $this->render('create', [
			'model' => $model
		]);
	}

	/**
	 * Updates an existing FundValue model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			if ($model->save()) {
				Yii::$app->session->setFlash("notify", ["type" => "success", "message" => Yii::t('app', 'Update Success!')]);
				Yii::$app->session->setFlash("pjax-reload", [
					"target" => "#dashboard-content",
					"pjaxContainer" => "#FundValueContainer",
					"reloadUrl" => Url::to(["index", "fid" => $model->fid])
				]);
				Yii::$app->session->setFlash("modal-close");
			} else {
				Yii::$app->session->setFlash("notify", ["type" => "warning", "message" => Yii::t('app', 'Update Failed!')]);
			}
		}

		return $this->render('update', ['model' => $model]);
	}

	/**
	 * Deletes an existing FundValue model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		if (Yii::$app->request->isPost) {
			$this->findModel($id)->delete();
		}
	}

	public function actionMultipleDelete() {
		Yii::$app->response->format = "json";
		if (Yii::$app->request->isPost) {
			$post = Yii::$app->request->post();
			if (!$post["ids"]) {
				$post["ids"] = [];
			}
			$models = FundValue::find()->where(["in", "id", $post["ids"]])->all();
			foreach ($models as $model) {
				$model->delete();
			}
			return ["success" => true, "data" => $post["ids"]];
		}
	}

	public function actionImport($id) {
		$fund = Fund::findOne($id);
		if ($fund) {
			if (Yii::$app->request->isPost) {
				$file = UploadedFile::getInstanceByName('excel');
				if ($file) {
					$document = \PHPExcel_IOFactory::load($file->tempName);
					$activeSheetData = $document->getActiveSheet();
					$highestRow = $activeSheetData->getHighestRow();

					$dateValidator = new \yii\validators\DateValidator(["format" => "php:Y-m-d"]);
					$numberValidator = new \yii\validators\NumberValidator();

					$data = []; $failed = [];

					for ($row = 1; $row <= $highestRow; $row++){
						$cell = $activeSheetData->getCell('A' . $row);
						$date = $cell->getValue();
						if(\PHPExcel_Shared_Date::isDateTime($cell)) {
							 $date = date("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($date));
						}
						$cell = $activeSheetData->getCell('B' . $row);
						$value = $cell->getValue();

						$result = [ "日期" => $date, "净值" => $value ];
						if ($dateValidator->validate($date)
								&& $numberValidator->validate($value)) {
							$data[] = $result;
						} else {
							$failed[] = $result;
						}
					}
					return $this->renderPartial('import-confirm', [
								"fund" => $fund, "file" => $file,
								"data" => $data, "failed" => $failed
							]);
				}
			}
			return $this->render('import', ["fund" => $fund]);
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionImportSave($id) {
		$fund = Fund::findOne($id);
		if ($fund) {
			if (Yii::$app->request->isPost) {
				$post = Yii::$app->request->post();
				if (isset($post["FundValue"]) && isset($post["FundValue"]["time"]) && isset($post["FundValue"]["fvalue"])) {
					$timeArray = $post["FundValue"]["time"];
					$fvalueArray = $post["FundValue"]["fvalue"];
					if (count($timeArray) == count($fvalueArray)) {
						$failed = [];
						for ($i = 0; $i < count($timeArray); $i++) {
							$fundvalue = FundValue::findOne([ "fid" => $id, "time" => $timeArray[$i], ]);
							if ($fundvalue) {
								$failed[] = [ "日期" => $timeArray[$i], "净值" => $fvalueArray[$i], "message" => "该日期已存在净值" ];
							} else {
								$fundvalue = new FundValue([
									"fid" => $id,
									"time" => $timeArray[$i],
									"fvalue" => $fvalueArray[$i],
								]);
								if (!$fundvalue->save()) {
									$failed[] = [ "日期" => $timeArray[$i], "净值" => $fvalueArray[$i], "message" => "保存失败" ];
								}
							}
						}

						Yii::$app->session->setFlash("pjax-reload", [
							"target" => "#dashboard-content",
							"pjaxContainer" => "#FundValueContainer",
							"reloadUrl" => Url::to(["index", "fid" => $fund->id])
						]);
						if (count($failed) > 0) {
							Yii::$app->session->setFlash("notify", [ "type" => "warning", "message" => "部分数据未提交成功" ]);
							return $this->render('import-feedback', ["failed" => $failed]);
						} else {
							Yii::$app->session->setFlash("notify", [ "type" => "success", "message" => "提交成功" ]);
							Yii::$app->session->setFlash("modal-close");
							return $this->render('import', ["fund" => $fund]);
						}
					}
				}
			}

			Yii::$app->session->setFlash("notify", [
				"type" => "warning",
				"message" => "数据格式不正确，请验证后重新提交"
			]);
			Yii::$app->session->setFlash("modal-close");
			return $this->render('import', ["fund" => $fund]);
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * Finds the FundValue model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return FundValue the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = FundValue::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
