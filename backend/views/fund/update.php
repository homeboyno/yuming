<?php

use common\models\FundAbstractSearch;
use common\models\FundManagerRelation;
use common\models\FundValueSearch;
use common\models\NotifySearch;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model common\models\Fund */

?>
<div class="fund-update" style="padding-bottom: 100px; overflow: auto">

    <?=$this->render('_form', ['model' => $model])?>

    <div class="col-sm-12">
        <div class="card card-nav-tabs">
        	<div class="header header-success">
        		<!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
        		<div class="nav-tabs-navigation">
        			<div class="nav-tabs-wrapper">
                        <?=yii\bootstrap\Tabs::widget([
                              'items' => [
                                  [
                                      'label' => '<i class="material-icons">face</i>基金经理',
                                      'active' => true,
                                      'options' => ['id' => 'fund-manager'],
                                  ],
                                  [
                                      'label' => '<i class="material-icons">timeline</i>基金净值',
                                      'options' => ['id' => 'fund-value'],
                                  ],
                                  [
                                      'label' => '<i class="material-icons">chat</i>缩略信息',
                                      'options' => ['id' => 'fund-abstract'],
                                  ],
                                  [
                                      'label' => '<i class="material-icons">image</i>信息公示',
                                      'options' => ['id' => 'notify'],
                                  ],
                              ],
                              'renderTabContent' => false,
                              'encodeLabels' => false
                          ]); ?>
        			</div>
        		</div>
        	</div>
        	<div class="content">
        		<div class="tab-content text-center">
        			<div class="tab-pane active" id="fund-manager">
                        <?php
                            $fmQuery = FundManagerRelation::find()->where(["fid" => $model->id]);
                            $fmdataProvider = new ActiveDataProvider(['query' => $fmQuery]);
                            $fmdataProvider->setPagination(["pageSize" => 20]);

                            echo $this->render('/fund-manager-relation/index', [
                                'dataProvider' => $fmdataProvider,
                                'fid' => $model->id,
                            ]);
                        ?>
        			</div>
        			<div class="tab-pane" id="fund-value">
                        <?php
                            $fvSearchModel = new FundValueSearch();
                            $fvDataProvider = $fvSearchModel->search(["FundValueSearch" => ["fid" => $model->id]]);
                            $fvDataProvider->setPagination(["pageSize" => 10, "route" => "/fund-value/index", "params" => ["fid" => $model->id]]);

                            echo $this->render('/fund-value/index', [
                            	'searchModel' => $fvSearchModel,
                            	'dataProvider' => $fvDataProvider,
                            	'fid' => $model->id,
                            ]);
                        ?>
        			</div>
        			<div class="tab-pane" id="fund-abstract">
                        <?php
                            $faSearchModel = new FundAbstractSearch();
                            $faDataProvider = $faSearchModel->search(["FundAbstractSearch" => ["fund_id" => $model->id]]);
                            $faDataProvider->setPagination(["pageSize" => 5, "route" => "/fund-abstract/index", "params" => ["fund_id" => $model->id]]);

                            echo $this->render('/fund-abstract/index', [
                            	'searchModel' => $faSearchModel,
                            	'dataProvider' => $faDataProvider,
                            	'fund_id' => $model->id,
                            ]);
                        ?>
        			</div>
                    <div class="tab-pane" id="notify">
                        <?php
                            $nSearchModel = new NotifySearch();
                            $nDataProvider = $nSearchModel->search(["NotifySearch" => ["fund_id" => $model->id]]);
                            $nDataProvider->setPagination(["pageSize" => 5, "route" => "/notify/index", "params" => ["fid" => $model->id]]);

                            echo $this->render('/notify/index', [
                            	'searchModel' => $nSearchModel,
                            	'dataProvider' => $nDataProvider,
                            	'fid' => $model->id,
                            ]);
                        ?>
                    </div>
        		</div>
        	</div>
        </div>
    </div>
</div>
