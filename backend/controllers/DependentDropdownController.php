<?php


namespace backend\controllers;

use yii\web\Controller;
use common\models\HtmlHelpers;
use backend\models\IdentificationCardInitial;

class DependentDropdownController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionInitial($id){
        echo HtmlHelpers::dropDownList(IdentificationCardInitial::className(), 'identification_card_type_id', $id, 'id', 'initial');
    }
}