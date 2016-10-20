<?php

namespace backend\controllers;

use Yii;
use backend\models\Profile;
use backend\models\search\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use common\models\PermissionHelpers;
use common\models\RecordHelpers;
use yii\web\UploadedFile;

Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/uploads/';
/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => 
                [
                    [
                        'actions' => ['index', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermissionHelpers::requireMinimumRole('Seller')
                                    && PermissionHelpers::requireStatus('Active');
                        }
                    ],
                    [
                        'actions' => [ 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermissionHelpers::requireMinimumRole('Seller')
                                    && PermissionHelpers::requireStatus('Active');
                        }
                    ],
                ],
            ],
                            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (PermissionHelpers::requireMinimumRole('Admin') 
                && PermissionHelpers::requireStatus('Active')){
            $searchModel = new ProfileSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } elseif (PermissionHelpers::requireRole('Seller') 
                && PermissionHelpers::requireStatus('Active')){
            if ($already_exists = RecordHelpers::userHas('profile')) {
                return $this->render('view', [
                    'model' => $this->findModel($already_exists),
                ]);
            } else {
                return $this->redirect(['create']);
            }
        }
    }

    /**
     * Displays a single Profile model.
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
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();

        if (PermissionHelpers::requireRole('Seller') 
                && PermissionHelpers::requireStatus('Active')){
            $model->user_id = \Yii::$app->user->identity->id;
        
            if ($already_exists = RecordHelpers::userHas('profile')) {
                return $this->render('view', [
                    'model' => $this->findModel($already_exists),
                    ]);
            } elseif ($model->load(Yii::$app->request->post())){
                // get the uploaded file instance. for multiple file uploads
                // the following data will return an array
                $image = $model->uploadImage();

                try {
                    if ($model->validate() && $model->save()){
                        // upload only if valid uploaded file instance found
                        if ($image !== false) {
                            $path = $model->getImageFile();
                            $image->saveAs($path);
                        }
                        return $this->redirect(['view', 'id' => $model->user_id]);
                    }
                } catch (Exception $ex) {
                    throw new HttpException(405, 'Error saving model');
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    ]);
            }
        } elseif (PermissionHelpers::requireMinimumRole('Admin') 
                && PermissionHelpers::requireStatus('Active')){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }
    
    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (PermissionHelpers::requireRole('Seller') 
                && PermissionHelpers::requireStatus('Active')){
            if($model = Profile::find()->where(['user_id' =>Yii::$app->user->identity->id])->one()) {
                $oldFile = $model->getImageFile();
                $oldAvatar = $model->avatar;
                $oldFileName = $model->filename;
                
                if ($model->load(Yii::$app->request->post())) {
                    // process uploaded image file instance
                    $model->image = $model->uploadImage();
                    // $archivo = \yii\web\UploadedFile::getInstance($model, 'image');
                    // $imagepath = Yii::$app->params['uploadPath'];
                    
                    if ($model->validate()){

                        // revert back if no valid file instance uploaded
                        if ($model->image === false) {
                            $model->avatar = $oldAvatar;
                            $model->filename = $oldFileName;
                        }

                        try {
                            if ($model->save()){
                                // upload only if valid uploaded file instance found
                                if ($model->image !== false && unlink($oldFile)) { // delete old and overwrite
                                    $path = $model->getImageFile();
                                    $model->image->saveAs($path);
                                }
                                return $this->redirect(['view', 'id' => $model->id]);
                                /*
                                return $this->render('prueba', [
                                    'archivo' => $archivo, 
                                    'nombre' => $model->filename,
                                    'model' => $model,
                                    'image' => $image,
                                    'imagepath' => $imagepath,
                                    ]);
                                 * 
                                 */
                            } else {
                                return $this->render('update', [
                                    'model' => $model,
                                ]);
                            }
                        } catch (Exception $ex) {
                            throw new HttpException(405, 'Error updating model');
                        }
                    } else {
                        throw new HttpException(405, 'Wrong image type - Model not updated');
                    }
                } else {
                    return $this->render('update', [
                        'model' => $model,
                        ]);
                }
            } else {
                throw new NotFoundHttpException('No Such Profile.');
            }
        } elseif (PermissionHelpers::requireMinimumRole('Admin')
                && PermissionHelpers::requireStatus('Active')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (PermissionHelpers::requireMinimumRole('Admin')
                && PermissionHelpers::requireStatus('Active')){
            $model = $this->findModel($id);
            
            // validate deletion and on failure process any exception 
            // e.g. display an error message 
            if ($model->delete()) {
                if (!$model->deleteImage()) {
                    Yii::$app->session->setFlash('error', 'Error deleting image');
                }
            }
            
            return $this->redirect(['index']);
        } else {
                throw new NotFoundHttpException('You are not allowed to perform this action.');
            }
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
