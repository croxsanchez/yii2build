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
     * MODIFY THIS VALUE ONLY in case of needing to change the total number of 
     * seller-records per level for the sellers' organization.
     */
    const MAX_NUMBER_OF_SELLERS_PER_LEVEL = 20;
    const MAX_LEVEL_DEPTH = 3;
    private $organization_level = 0;


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
        if (PermissionHelpers::requireRole('Superuser')
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
    public function actionMyOrganization($seller_user_id, $parent_seller_id=1, $offset=0)
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Seller')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new SellerSearch();
            $dataProvider = $searchModel->searchMyOrganization(Yii::$app->request->queryParams);

            if ($seller_user_id == Yii::$app->user->id){
                $this->organization_level = 1;
                return $this->render('my-organization', [
                        'searchModel'  => $searchModel,
                        'dataProvider' => $dataProvider,
                        'seller_user_id' => $seller_user_id,
                        'parent_seller_id' => $parent_seller_id
                    ]);
            } else {
                if ($this->changeOrganizationLevel($offset) <= self::MAX_LEVEL_DEPTH){
                    return $this->renderAjax('my-organization', [
                            'searchModel'  => $searchModel,
                            'dataProvider' => $dataProvider,
                            'seller_user_id' => $seller_user_id,
                            'parent_seller_id' => $parent_seller_id
                        ]);
                } else {
                    throw new NotFoundHttpException('You\'re not allowed to enter this level.');
                }
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
        if(!Yii::$app->user->isGuest &&
            (PermissionHelpers::requireRole('Seller') || PermissionHelpers::requireRole('Superuser'))
                    && PermissionHelpers::requireStatus('Active')){
            $seller_user_id = Yii::$app->user->id;

            // Check for availability in seller organization's 1st level.
            if ($this->firstLevelTotal($seller_user_id) < self::MAX_NUMBER_OF_SELLERS_PER_LEVEL ){
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
            } else {
                throw new NotFoundHttpException('You\'ve reached the maximum number of sellers you can create.');
            }
        }
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
    
    /**
     * Returns the total num of records for the seller organization's 1st level.
     * @return integer
     */
    public function firstLevelTotal($id)
    {
        $query = new \yii\db\Query();
        $result = $query->select('COUNT(*)')
            ->from('seller')
            ->where(['parent_id' => $id])
            ->one();

        return $total = $result['count'];
    }
    
    /**
     * Changes the organization_level attribute.
     * @param integer $offset
     * @return integer
     */
    public function changeOrganizationLevel($offset) {
        return $this->organization_level += $offset;
    }
}
