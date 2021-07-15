<?php

frontend\assets\AboutAsset::register($this);

?>

<div class="us-title">
    <h2>走进友山</h2>
    <p>领导介绍</p>
</div>
<div class="executives">
    <div class="row">
        <div class="col-sm-4 text-center">
            <?= $this->render('_executive_block', [
                        'icon' => 'assignment_ind',
                        'apartment' => "董事会", 
                        'execs' => $execs["董事会"]]); 
                    ?>
        </div>
        <div class="col-sm-offset-4 col-sm-4 text-center">
            <?= $this->render('_executive_block', [
                        'icon' => 'assignment_ind',
                        'apartment' => "监事会", 
                        'execs' => $execs["监事会"]]); 
                    ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 text-center">
            <?= $this->render('_executive_block', [
                        'icon' => 'assignment_ind',
                        'apartment' => "高级管理层", 
                        'execs' => $execs["高级管理层"]]); 
                    ?>
        </div>
        <div class="col-sm-4 text-center">
            <?= $this->render('_executive_block', [
                        'icon' => 'assignment_ind',
                        'apartment' => "党总支", 
                        'execs' => $execs["党总支"]]); 
                    ?>
        </div>
        <div class="col-sm-4 text-center">
            <?= $this->render('_executive_block', [
                        'icon' => 'assignment_ind',
                        'apartment' => "工会", 
                        'execs' => $execs["工会"]]); 
                    ?>
        </div>
    </div>
</div>

<style type="text/css">
.card {
    margin-top: 30px;
}
.table td, .table th {
    text-align: center;
}
</style>