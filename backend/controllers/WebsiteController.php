<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\Website;
use backend\models\customer\WebsiteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\customer\Domain;
use backend\models\DesignerWebsite;
use backend\models\customer\PreDomain;
use common\models\PermissionHelpers;
use yii\data\ArrayDataProvider;

/**
 * WebsiteController implements the CRUD actions for Website model.
 */
class WebsiteController extends Controller
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
     * Lists all Website models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebsiteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Website model.
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
     * Creates a new Website model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($customer_id)
    {
        $model = new Website();
        $domain1 = new PreDomain();
        $domain2 = new PreDomain();

        if ($model->load(Yii::$app->request->post()) 
                && $domain1->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id]);
            if ($model->save()){
                $domain1->customer_id = $model->customer_id;
                $domain1->website_id = $model->id;
                $domain1->domain_choice_value = 10;
                $domain1->domain_status_value = 10;
                $domain1->save();
                
                $domain2->name = $domain1->second_name;
                $domain2->customer_id = $model->customer_id;
                $domain2->website_id = $model->id;
                $domain2->domain_choice_value = 20;
                $domain2->domain_status_value = 10;
                $domain2->save();
            }
            return $this->goBack();
        } else {
            return $this->render('create', [
                'model' => $model,
                'domain1' => $domain1,
                'customer_id' => $customer_id
            ]);
        }
    }

    /**
     * Updates an existing Website model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Website model.
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
     * Displays the list of customers with sites pending for payment
     * for the current seller.
     */
    public function actionWebsitesPendingForFirstPayment()
    {
        if (!Yii::$app->user->isGuest 
                && PermissionHelpers::requireRole('Admin') 
                && PermissionHelpers::requireStatus('Active')){
            $searchModel = new WebsiteSearch();
            $dataProvider = $searchModel->searchWebsitesPendingForFirstPayment();
            $this->storeReturnUrl();

            return $this->render('websites-pending-for-first-payment', [
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
    public function actionWebsitesForDevelopment($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new WebsiteSearch();
            $dataProvider = $searchModel->searchMyWebsitesForDevelopment(Yii::$app->request->queryParams);
            $this->storeReturnUrl();

            return $this->render('websites-for-development', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Updates an existing Website model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSendToDevelopment($id)
    {
        $model = $this->findModel($id);
        $domain = new Domain();
        $designer_website = new DesignerWebsite();
        $dataProvider = new ArrayDataProvider([
            'allModels' => PreDomain::find()->where(['website_id' => $model->id])->all(),
        ]);
        
        if ($model->load(Yii::$app->request->post()) 
                && $domain->load(Yii::$app->request->post())
                && $designer_website->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $domain->customer_id = $model->customer_id;
            $domain->domain_status_value = 20;
            
            if ($domain->save() && $designer_website->save()){
                $model->domain_id = $domain->id;
                $model->save();
                return $this->goBack();
            } else{
                throw new NotFoundHttpException('Error modifying the database.');
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('send-to-development', [
                'model' => $model,
                'customer_id' => $model->customer_id,
                'domain' => $domain,
                'designer_website' => $designer_website,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Website model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSendToDesign($id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $model = $this->findModel($id);
            $domain = Domain::findOne(['id' => $model->domain_id]);

            if (!empty($domain)){
                // Assign the 'Design' status to domain_satus_value property
                $domain->domain_status_value = 30;
                if ($domain->save()){
                    return $this->goBack();
                } else {
                    throw new NotFoundHttpException('Error modifying the database.');
                }
            }
        } else {
            throw new NotFoundHttpException('You\'re not allowed to perform this action.');
        }
    }

    /**
     * Updates an existing Website model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAssignToDesigner($id)
    {
        $model = $this->findModel($id);
        /*
         * En esta acción se tiene que asignar un website a un diseñador
         * Para lograr esto se pretende hacer una tabla que sea la relación
         * entre las tablas website y designer (tabla de usuariosr con rol 
         * 'designer'). De esta manera se manejan aparte también los diseñadores
         * ta como se hace con los vendedores.
         */
        
        $domain = new Domain();        
        $dataProvider = new ArrayDataProvider([
            'allModels' => PreDomain::find()->where(['website_id' => $model->id])->all(),
        ]);
        
        if ($model->load(Yii::$app->request->post()) 
                && $domain->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $domain->customer_id = $model->customer_id;
            $domain->domain_status_value = 20;
            if ($domain->save()){
                $model->domain_id = $domain->id;
                $model->save();
                return $this->goBack();
            } else{
                throw new NotFoundHttpException('Error modifying the database.');
            }
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('send-to-development', [
                'model' => $model,
                'customer_id' => $model->customer_id,
                'domain' => $domain,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays the list of websites with domains already published
     * for the current seller.
     */
    public function actionListPublishedWebsites($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new WebsiteSearch();
            $dataProvider = $searchModel->searchMyPublishedWebsites(Yii::$app->request->queryParams);

            return $this->render('published-websites', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);

        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Finds the Website model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Website the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Website::findOne($id)) !== null) {
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
