<?php

namespace backend\controllers;

use Yii;
use backend\models\customer\PublishedSite;
use backend\models\customer\PublishedSiteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;
use backend\models\customer\Website;
use backend\models\customer\Domain;

/**
 * PublishedSiteController implements the CRUD actions for PublishedSite model.
 */
class PublishedSiteController extends Controller
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
     * Lists all Site models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublishedSiteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Site model.
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
     * Creates a new PublishedSite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($website_id, $designer_id, $seller_id, $customer_id)
    {
        $model = new PublishedSite();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->goBack();
        } else {
            return $this->render('create', [
                'model' => $model,
                'website_id'  => $website_id,
                'designer_id' => $designer_id,
                'seller_id' => $seller_id,
                'customer_id' => $customer_id,
            ]);
        }
    }

    /**
     * Creates a new PublishedSite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateTemporarySite($website_id, $designer_id, $seller_id, $customer_id)
    {
        $model = new PublishedSite();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->goBack();
        } else {
            return $this->render('create_temporary_site', [
                'model' => $model,
                'website_id'  => $website_id,
                'designer_id' => $designer_id,
                'seller_id' => $seller_id,
                'customer_id' => $customer_id,
            ]);
        }
    }

    /**
     * Updates an existing Site model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing Site model.
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
     * Displays the list of customers with domains pending for payment
     * for the current seller.
     */
    public function actionListMyTemporaryWebsites($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new PublishedSiteSearch();
            $dataProvider = $searchModel->searchMyTemporaryPublishedWebsites(Yii::$app->request->queryParams);
            $this->storeReturnUrl();

            return $this->render('my-temporary-published-websites', [
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
    public function actionListMyPublishedWebsites($seller_user_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new PublishedSiteSearch();
            $dataProvider = $searchModel->searchMyPublishedWebsites(Yii::$app->request->queryParams);
            $this->storeReturnUrl();

            return $this->render('my-published-websites', [
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
    public function actionModifyWebsite($website_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $domain_id = Website::findOne($website_id)->domain_id;
            $domain = Domain::findOne($domain_id);

            if (!empty($domain)){
                // Assign the 'Update' status to domain_satus_value property
                $domain->domain_status_value = 50;
                if ($domain->save()){
                    return $this->goBack();
                } else {
                    throw new NotFoundHttpException('Error modifying the database.');
                }
            }
        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Displays the list of customers with domains pending for payment
     * for the current seller.
     */
    public function actionApproveWebsite($website_id)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $domain_id = Website::findOne($website_id)->domain_id;
            $domain = Domain::findOne($domain_id);

            if (!empty($domain)){
                // Assign the 'Approved' status to domain_satus_value property
                $domain->domain_status_value = 60;
                if ($domain->save()){
                    return $this->goBack();
                } else {
                    throw new NotFoundHttpException('Error modifying the database.');
                }
            }
        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }
    }

    /**
     * Finds the Site model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Site the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Site::findOne($id)) !== null) {
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
