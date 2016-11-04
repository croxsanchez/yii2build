<?php

namespace backend\controllers;

use Yii;
use backend\models\SellerPhone;
use backend\models\search\SellerPhoneSearch;
use backend\utilities\SubmodelController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SellerPhoneController implements the CRUD actions for SellerPhone model.
 */
class SellerPhoneController extends SubmodelController
{
    public $recordClass = 'backend\models\SellerPhone';
    public $relationAttribute = 'seller_id';
}
