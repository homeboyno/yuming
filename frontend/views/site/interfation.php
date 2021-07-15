<?php

use yii\helpers\Html;
frontend\assets\AboutAsset::register($this);
function getxingb($type){
    if($type==0){
        return '女';
    }else{
        return '男';
    }
    return '男';
    
}
// include "inner-banner.php";
?>
<table style="width:100%">
    <tr>
        <th style="width=25%">姓名</th>
        <th style="width=25%">电话</th>
        <th style="width=25%">性别</th>
        <th style="width=25%">邮箱</th>
</tr>


<?php
$posts = Yii::$app->db->createCommand('SELECT * FROM user')
            ->queryAll();

$length=count($posts);
$arra = ['女','男','男'];
for($i=0; $i<$length; $i++){
  echo('<tr><td>'.$posts[$i]['username'].'</td>');
  echo('<td>'.$posts[$i]['phone'].'</td>');
  echo('<td>'.$posts[$i]['type'].'</td>');
  echo('<td>'.$posts[$i]['email'].'</td></tr>');
}
?>
</table>
<div>
    it's test
</div>