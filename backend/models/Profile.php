<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use frontend\models\Gender;
use yii\web\UploadedFile;
use backend\models\SellerAddress;
use backend\models\SellerPhone;

Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/uploads/';

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $filename
 * @property string $avatar
 * @property string $birth_date
 *
 * @property Gender $gender
 */
class Profile extends ActiveRecord
{
    public $image;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender_id'], 'integer'],
            [['created_at', 'updated_at', 'birth_date'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 45],
            [['birth_date'], 'date', 'format'=>'Y-m-d'],
            [['image'], 'safe'],
            [['image'], 'image', 'extensions' => 'jpg, gif, png', 'mimeTypes' => 'image/jpeg, image/gif, image/png'],
            [['image'], 'image', 'maxSize'=> '10000000'],
            [['filename', 'avatar'], 'safe'],
            [['filename', 'avatar'], 'string', 'max' => 255],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::className(), 'targetAttribute' => ['gender_id' => 'id']],
            [['gender_id'],'in', 'range'=>array_keys($this->getGenderList())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender_id' => 'Gender ID',
            'filename' => Yii::t('app', 'Filename'),
            'avatar' => Yii::t('app', 'Avatar'),
            'created_at' => 'Member Since',
            'updated_at' => 'Last Updated',
            'genderName' => Yii::t('app', 'Gender'),
            'userLink' => Yii::t('app', 'User'),
            'sellerPhones' => Yii::t('app', 'Phone Numbers'),
            'sellerAddresses' => Yii::t('app', 'Addresses'),
            'email' => Yii::t('app', 'Email'),
            'profileIdLink' => Yii::t('app', 'Profile'),
            'birth_date' => 'Birth Date (Optional)',
        ];
    }

    /**
    * behaviors to control time stamp, don't forget to use statement for expression
    *
    */
    public function behaviors(){
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                'value' => new Expression('NOW()'),
                ],
            ];
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellerPhones()
    {
        return $this->hasMany(SellerPhone::className(), ['seller_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellerAddresses()
    {
        return $this->hasMany(SellerAddress::className(), ['seller_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }
    
    /**
    * uses magic getGender on return statement
    *
    */
    public function getGenderName(){
        return $this->gender->gender_name;
    }
    
    /**
    * get list of genders for dropdown
    */
    public static function getGenderList(){
        $droptions = Gender::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'gender_name');
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
    * @get Username
    */
    public function getUsername(){
        return $this->user->username;
    }
    
    /**
    * @get Username
    */
    public function getEmail(){
        return $this->user->email;
    }
    
    /**
    * @getUserId
    */
    public function getUserId(){
        return $this->user ? $this->user->id : 'none';
    }
    
    /**
    * @getUserLink
    */
    public function getUserLink(){
        $url = Url::to(['user/view', 'id'=>$this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }
    
    /**
    * @getProfileLink
    */
    public function getProfileIdLink(){
        $url = Url::to(['profile/update', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }
    
    public function beforeValidate(){
        if ($this->birth_date != null) {
            $new_date_format = date('Y-m-d', strtotime($this->birth_date));
            $this->birth_date = $new_date_format;
        }
        return parent::beforeValidate();
    }
    
    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        return isset($this->avatar) ? Yii::$app->params['uploadPath'] . $this->avatar : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $avatar;
    }

    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->filename = $image->name;
        $ext = end((explode(".", $image->name)));

        // generate a unique file name
        $this->avatar = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }

    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->avatar = null;
        $this->filename = null;

        return true;
    }
}
