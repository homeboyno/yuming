<?php
namespace frontend\components;

use Yii;

class EditeAction extends \yii\base\Action
{
    public $id;
    public $name;

    public function run()
    {
        return $this->controller->render('simpleEdition', [
			'id' => $this->id,
			'name' => \common\models\Edite::editeList()[$this->id],
		]);
    }
}
