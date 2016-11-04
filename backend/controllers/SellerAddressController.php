<?php

namespace backend\controllers;

use Yii;
use backend\models\SellerAddress;
use backend\models\search\SellerAddressSearch;
use backend\utilities\SubmodelController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SellerPhoneController implements the CRUD actions for SellerPhone model.
 */
class SellerAddressController extends SubmodelController
{
    public $recordClass = 'backend\models\SellerAddress';
    public $relationAttribute = 'seller_id';
}
