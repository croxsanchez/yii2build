<?php

namespace backend\controllers;

use Yii;
use backend\models\Seller;
use backend\models\search\SellerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;
use backend\models\SellerForm;
use common\models\User;
use common\models\PermissionHelpers;

/**
 * SellerController implements the CRUD actions for Seller model.
 */
class SellerController extends Controller
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

    public function actionParams()
    {
        $model = new SellerSearch();
        return $this->render('view',
                [
                    'params' => Yii::$app->request->queryParams,
                    'model' => $model,
                ]);
    }
    
    /**
     * Lists all Seller models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (PermissionHelpers::requireMinimumRole('Admin')
                && PermissionHelpers::requireStatus('Active')){
            $searchModel = new SellerSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif (PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            return $this->redirect([
                'my-organization',
                'seller_user_id' => Yii::$app->user->id,
            ]);

        }
    }

    /**
     * Displays the first level of sellers the current seller's 
     * "My Organization".
     * @return mixed
     */
    public function actionMyOrganization($seller_user_id, $parent_seller_id=0)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new SellerSearch();
            $dataProvider = $searchModel->searchMyOrganization(Yii::$app->request->queryParams);

            if ($seller_user_id == Yii::$app->user->id){
                return $this->render('my-organization', [
                        'searchModel'  => $searchModel,
                        'dataProvider' => $dataProvider,
                        'seller_user_id' => $seller_user_id,
                        'parent_seller_id' => $parent_seller_id
                    ]);
            } else {
                return $this->renderAjax('my-organization', [
                        'searchModel'  => $searchModel,
                        'dataProvider' => $dataProvider,
                        'seller_user_id' => $seller_user_id,
                        'parent_seller_id' => $parent_seller_id
                    ]);
            }
        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this site.');
        }
    }

    /**
     * Displays a single Seller model.
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
     * Creates a new Seller model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SellerForm();
        $model->setScenario('create');
        
        if ($model->load(Yii::$app->request->post())) {
            if ($seller = $model->create()) {
                return $this->redirect(['view', 'id' => $seller->getId()]);
            } else {
                throw new NotFoundHttpException('There were errors creating new User, Seller or Sub-model.');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
        /*$model = new Seller();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Updates an existing Seller model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Seller model.
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
     * Finds the Seller model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seller the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seller::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
