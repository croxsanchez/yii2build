<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\PhoneRecord;
use yii\data\ActiveDataProvider;
use backend\utilities\SubmodelController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhonesController implements the CRUD actions for PhoneRecord model.
 */
class PhonesController extends SubmodelController
{
    public $recordClass = 'backend\models\customer\PhoneRecord';
    public $relationAttribute = 'customer_id';
}
