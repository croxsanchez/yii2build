<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\CustomerRecord;
use backend\models\customer\CustomerRecordSearch;
use backend\models\customer\AddressRecord;
use backend\models\customer\EmailRecord;
use backend\models\customer\PhoneRecord;
use backend\models\customer\Website;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;
use common\models\RecordHelpers;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use backend\models\Model;
use yii\helpers\ArrayHelper;

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
            $modelsAddress = [new AddressRecord()];
            $modelsEmail = [new EmailRecord()];
            $modelsPhone = [new PhoneRecord()];
            //$modelsWebsite = [new Website()];
            $model->setScenario('create');

            if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
                $modelsAddress = Model::createMultiple(AddressRecord::classname());
                $modelsEmail = Model::createMultiple(EmailRecord::classname());
                $modelsPhone = Model::createMultiple(PhoneRecord::classname());
                //$modelsWebsite = Model::createMultiple(Website::classname());
                Model::loadMultiple($modelsAddress, Yii::$app->request->post());
                Model::loadMultiple($modelsEmail, Yii::$app->request->post());
                Model::loadMultiple($modelsPhone, Yii::$app->request->post());
                //Model::loadMultiple($modelsWebsite, Yii::$app->request->post());
                
                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($modelsAddress),
                        ActiveForm::validateMultiple($modelsEmail),
                        ActiveForm::validateMultiple($modelsPhone),
                        //ActiveForm::validateMultiple($modelsWebsite),
                        ActiveForm::validate($model)
                    );
                }

                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsAddress) && $valid;
                $valid = Model::validateMultiple($modelsEmail) && $valid;
                $valid = Model::validateMultiple($modelsPhone) && $valid;
                //$valid = Model::validateMultiple($modelsWebsite) && $valid;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsAddress as $modelAddress) {
                                $modelAddress->customer_id = $model->id;
                                if (! ($flag = $modelAddress->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            foreach ($modelsEmail as $modelEmail) {
                                $modelEmail->customer_id = $model->id;
                                if (! ($flag = $modelEmail->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            foreach ($modelsPhone as $modelPhone) {
                                $modelPhone->customer_id = $model->id;
                                if (! ($flag = $modelPhone->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            /*foreach ($modelsWebsite as $modelWebsite) {
                                $modelWebsite->customer_id = $model->id;
                                if (! ($flag = $modelWebsite->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }*/
                        }
                        if ($flag) {
                            $transaction->commit();
                            //return $this->redirect(['view', 'id' => $model->id]);
                            return $this->redirect(['update', 'id' => $model->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else{
                    throw new NotFoundHttpException('CROX ESTÁS MEANDO FUERA DE POTE. TIENES QUE ARREGLAR LOS FORMULARIOS');
                }
                //return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'modelsAddress' => (empty($modelsAddress)) ? [new AddressRecord()] : $modelsAddress,
                    'modelsEmail' => (empty($modelsEmail)) ? [new EmailRecord()] : $modelsEmail,
                    'modelsPhone' => (empty($modelsPhone)) ? [new PhoneRecord()] : $modelsPhone,
                    'modelsWebsite' => (empty($modelsWebsite)) ? [new Website()] : $modelsWebsite
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
        $modelsAddress = $model->addresses;
        $modelsEmail = $model->emails;
        $modelsPhone = $model->phones;

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
            $oldIDs2 = ArrayHelper::map($modelsEmail, 'id', 'id');
            $oldIDs3 = ArrayHelper::map($modelsPhone, 'id', 'id');
            $modelsAddress = Model::createMultiple(AddressRecord::classname(), $modelsAddress);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $modelsEmail = Model::createMultiple(EmailRecord::classname(), $modelsEmail);
            Model::loadMultiple($modelsEmail, Yii::$app->request->post());
            $modelsPhone = Model::createMultiple(PhoneRecord::classname(), $modelsPhone);
            Model::loadMultiple($modelsPhone, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));
            $deletedIDs2 = array_diff($oldIDs2, array_filter(ArrayHelper::map($modelsEmail, 'id', 'id')));
            $deletedIDs3 = array_diff($oldIDs3, array_filter(ArrayHelper::map($modelsPhone, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsAddress),
                    ActiveForm::validateMultiple($modelsEmail),
                    ActiveForm::validateMultiple($modelsPhone),
                    ActiveForm::validate($model)
                );
            }
            
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            $valid = Model::validateMultiple($modelsEmail) && $valid;
            $valid = Model::validateMultiple($modelsPhone) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            AddressRecord::deleteAll(['id' => $deletedIDs]);
                        }
                        if (! empty($deletedIDs2)) {
                            EmailRecord::deleteAll(['id' => $deletedIDs2]);
                        }
                        if (! empty($deletedIDs3)) {
                            PhoneRecord::deleteAll(['id' => $deletedIDs3]);
                        }
                        foreach ($modelsAddress as $modelAddress) {
                            $modelAddress->customer_id = $model->id;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelsEmail as $modelEmail) {
                            $modelEmail->customer_id = $model->id;
                            if (! ($flag = $modelEmail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelsPhone as $modelPhone) {
                            $modelPhone->customer_id = $model->id;
                            if (! ($flag = $modelPhone->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsAddress' => (empty($modelsAddress)) ? [new AddressRecord()] : $modelsAddress,
                'modelsEmail' => (empty($modelsEmail)) ? [new EmailRecord()] : $modelsEmail,
                'modelsPhone' => (empty($modelsPhone)) ? [new PhoneRecord()] : $modelsPhone
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
