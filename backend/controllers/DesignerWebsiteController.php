<?php

namespace backend\controllers;

use Yii;
use backend\models\DesignerWebsite;
use backend\models\search\DesignerWebsiteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\customer\Website;
use backend\models\customer\Domain;
use common\models\PermissionHelpers;

/**
 * DesignerWebsiteController implements the CRUD actions for DesignerWebsite model.
 */
class DesignerWebsiteController extends Controller
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
     * Lists all DesignerWebsite models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DesignerWebsiteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DesignerWebsite model.
     * @param integer $designer_id
     * @param integer $website_id
     * @return mixed
     */
    public function actionView($designer_id, $website_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($designer_id, $website_id),
        ]);
    }

    /**
     * Creates a new DesignerWebsite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DesignerWebsite();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'designer_id' => $model->designer_id, 'website_id' => $model->website_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Assigns a Website to a Designer.
     * If assignation is successful, the browser will be redirected to ...
     * @return mixed
     */
    public function actionAssign($id)
    {
        $model = new DesignerWebsite();
        $website = Website::find()->select('id, description, domain_id')->where(['id' => $id])->asArray()->one();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'designer_id' => $model->designer_id, 'website_id' => $model->website_id]);
        } else {
            return $this->render('assign', [
                'model' => $model,
                'website' => $website,
            ]);
        }
    }

    /**
     * Displays the list of websites that are already assigned to a designer.
     */
    public function actionListAssignedWebsites()
    {
        if (!Yii::$app->user->isGuest &&
            PermissionHelpers::requireRole('Admin')
                    && PermissionHelpers::requireStatus('Active')){
            $searchModel = new DesignerWebsiteSearch();
            $dataProvider = $searchModel->searchAssignedWebsites(Yii::$app->request->queryParams);

            return $this->render('list-assigned-websites', [
                    'searchModel'  => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
        } else {
            throw new NotFoundHttpException('You\'re not allowed to enter this view.');
        }    
    }

    /**
     * Updates an existing DesignerWebsite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $designer_id
     * @param integer $website_id
     * @return mixed
     */
    public function actionUpdate($designer_id, $website_id)
    {
        $model = $this->findModel($designer_id, $website_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'designer_id' => $model->designer_id, 'website_id' => $model->website_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DesignerWebsite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $designer_id
     * @param integer $website_id
     * @return mixed
     */
    public function actionDelete($designer_id, $website_id)
    {
        $this->findModel($designer_id, $website_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DesignerWebsite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $designer_id
     * @param integer $website_id
     * @return DesignerWebsite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($designer_id, $website_id)
    {
        if (($model = DesignerWebsite::findOne(['designer_id' => $designer_id, 'website_id' => $website_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
