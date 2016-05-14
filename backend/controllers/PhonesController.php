<?php

namespace backend\controllers;

use backend\utilities\SubmodelController;
use Yii;
use backend\models\customer\PhoneRecord;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhonesController implements the CRUD actions for PhoneRecord model.
 */
class PhonesController extends SubmodelController
{
    public $recordClass = 'app\models\customer\PhoneRecord';
    public $relationAttribute = 'customer_id';
}
