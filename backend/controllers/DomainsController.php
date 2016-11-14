<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\DomainRecord;
use backend\models\customer\DomainRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;

/**
 * DomainsController implements the CRUD actions for DomainRecord model.
 */
class DomainsController extends Controller
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
     * Lists all DomainRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DomainRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DomainRecord model.
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
     * Displays the list of customers with domains pending for payment
     * for the current seller.
     */
    public function actionDomainsPendingForFirstPayment()
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Admin')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new DomainRecordSearch();
            $dataProvider = $searchModel->searchDomainsPendingForFirstPayment();

            return $this->render('domains-pending-for-first-payment', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Displays the list of customers with domains pending for payment
     * for the current seller.
     */
    public function actionListTemporaryDomains()
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Admin')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new DomainRecordSearch();
            $dataProvider = $searchModel->searchTemporaryDomains();

            return $this->render('list-temporary-domains', [
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
    public function actionListPublishedDomains($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new DomainRecordSearch();
            $dataProvider = $searchModel->searchMyPublishedDomains(Yii::$app->request->queryParams);

            return $this->render('published-domains', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Displays the list of customers with domains pending for payment
     * for the current seller.
     */
    public function actionDomainsForDevelopment($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new DomainRecordSearch();
            $dataProvider = $searchModel->searchMyDomainsForDevelopment(Yii::$app->request->queryParams);

            return $this->render('domains-for-development', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Creates a new DomainRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($customer_id)
    {
        $model = new DomainRecord();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->goBack();
        } else {
            return $this->render('create', [
                'model' => $model,
                'customer_id' => $customer_id
            ]);
        }
    }

    /**
     * Updates an existing DomainRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $customer_id = $model->customer_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->goBack();
        } else {
            return $this->render('update', [
                'model' => $model,
                'customer_id' => $customer_id
            ]);
        }
    }

    /**
     * Changes Domain Choices to a single Domain with "Development" status.
     * @param integer $id
     * @return mixed
     */
    public function actionChangeToDevelopment($id)
    {
        $model = $this->findModel($id);

        // Set Domain to be First Choice
        $model->setDomainChoiceValue(10);
        // Set Payment Status to Paid 1
        $model->setPaymentStatusValue(20);
        // Set Domain Status to 'Development'
        $model->setDomainStatusValue(20);

        return $this->goBack();
    }

    /**
     * Deletes an existing DomainRecord model.
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
     * Finds the DomainRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DomainRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DomainRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
