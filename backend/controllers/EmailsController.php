<?php

namespace backend\controllers;

use backend\utilities\SubmodelController;
use Yii;
use backend\models\customer\EmailRecord;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmailsController implements the CRUD actions for EmailRecord model.
 */
class EmailsController extends SubmodelController
{
    public $recordClass = 'app\models\customer\EmailRecord';
    public $relationAttribute = 'customer_id';
}
