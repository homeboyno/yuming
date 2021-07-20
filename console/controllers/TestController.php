<?php

namespace console\controllers;

use Yii;

use yii\console\Controller;
use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use common\models\Product;
use common\models\User;
use common\components\PermissDivide;

class TestController extends Controller
{
    public function actionIndex() {
        $password = "25d55ad283aa400af464c76d713c07ad";
        $encryptPassword = Yii::$app->getSecurity()->generatePasswordHash($password);
        $user = User::find(["phone" => 18551654408])->one();
        $user->password = $encryptPassword;
        echo $encryptPassword . "\n";
        if ($user->save()) echo 0;
        else {
            var_dump($user->getErrors());
        }
        var_dump(Yii::$app->getSecurity()->validatePassword($password, $encryptPassword));
    }
} 
