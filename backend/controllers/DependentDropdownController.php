<?php


namespace backend\controllers;

use yii\web\Controller;
use common\models\HtmlHelpers;
use backend\models\IdentificationCardInitial;
use backend\models\IdentificationCardType;

class DependentDropdownController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionCardType($id){
        echo HtmlHelpers::dropDownList(IdentificationCardType::className(), 'customer_type_value', $id, 'id', 'name');
    }
    
    public function actionInitial($id){
        echo HtmlHelpers::dropDownList(IdentificationCardInitial::className(), 'identification_card_type_id', $id, 'id', 'initial');
    }
}