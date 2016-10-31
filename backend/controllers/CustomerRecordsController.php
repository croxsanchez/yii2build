<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\CustomerRecord;
use backend\models\customer\CustomerRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;
use common\models\RecordHelpers;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * CustomerRecordsController implements the CRUD actions for CustomerRecord model.
 */
class CustomerRecordsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CustomerRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (PermissionHelpers::requireMinimumRole('Admin')
                && PermissionHelpers::requireStatus('Active')){
            $searchModel = new CustomerRecordSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif (PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            return $this->redirect([
                'my-customers',
                'seller_user_id' => Yii::$app->user->id,
            ]);

        }
    }

    /**
     * Displays the list of customers for the current seller.
     * @return mixed
     */
    public function actionMyCustomers($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new CustomerRecordSearch();
            $dataProvider = $searchModel->searchMyCustomers(Yii::$app->request->queryParams);

            return $this->render('my-customers', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                    'seller_user_id' => $seller_user_id,
                ]);
        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this site.');
        }
    }

    /**
     * Displays the list of customers with domains pending for payment
     * for the current seller.
     */
    public function actionCustomersPendingPayment($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new CustomerRecordSearch();
            $dataProvider = $searchModel->searchMyPendingForPayment(Yii::$app->request->queryParams);

            return $this->render('pending-for-payment', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Displays the list of customers with domains already paid out
     * for the current seller.
     */
    public function actionCustomersPaidOut($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new CustomerRecordSearch();
            $dataProvider = $searchModel->searchMyPaidOutCustomers(Yii::$app->request->queryParams);

            return $this->render('paid-out', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Displays a single CustomerRecord model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CustomerRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireMinimumRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $this->storeReturnUrl();
            $model = new CustomerRecord();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->createIdentCardRecord()) {
                    return $this->redirect(['update', 'id' => $model->id]);
                } else {
                        throw new NotFoundHttpException('There were errors creating new Customer.');
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('You\'re not allowed to perform this action.');
        }
    }

    /**
     * Updates an existing CustomerRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->storeReturnUrl();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CustomerRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CustomerRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function storeReturnUrl()
    {
        Yii::$app->user->returnUrl = Yii::$app->request->url;
    }
}
