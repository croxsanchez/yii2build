<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\AddressRecord;
use yii\data\ActiveDataProvider;
use backend\utilities\SubmodelController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AddressesController implements the CRUD actions for AddressRecord model.
 */
class AddressesController extends SubmodelController
{
    public $recordClass = 'backend\models\customer\AddressRecord';
    public $relationAttribute = 'customer_id';
}
