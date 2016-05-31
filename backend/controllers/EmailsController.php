<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\EmailRecord;
use yii\data\ActiveDataProvider;
use backend\utilities\SubmodelController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmailsController implements the CRUD actions for EmailRecord model.
 */
class EmailsController extends SubmodelController
{
    public $recordClass = 'backend\models\customer\EmailRecord';
    public $relationAttribute = 'customer_id';
}
