<?php

namespace backend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "seller".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $parent_id
 *
 */
class Seller extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seller';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','user_id', 'parent_id'], 'required'],
            [['id','user_id', 'parent_id'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idLink' => 'ID',
            'userLink' => 'User ID',
            'parentUserLink' => 'Parent ID',
        ];
    }
    
    /**
    * @getId
    */
    public function getId(){
        return $this->getPrimaryKey();
    }
    
    /**
    * @getIdLink
    * get seller id Link
    *
    */
    public function getIdLink(){
        $url = Url::to(['seller/view', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
    * @getUsername
    *
    */
    public function getUsername(){
        return $this->user ? $this->user->username : '- no user -';
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentUser()
    {
        return $this->hasOne(User::className(), ['id' => 'parent_id']);
    }
    
    /**
    * @getUserIdLink
    *
    */
    public function getUserIdLink(){
        $url = Url::to(['user/update', 'id'=>$this->user_id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }
    
    /**
    * @getUserLink
    *
    */
    public function getUserLink(){
        $url = Url::to(['user/view', 'id'=>$this->user_id]);
        $options = [];
        return Html::a($this->username, $url, $options);
    }
    
    /**
    * @getParentUsername
    *
    */
    public function getParentUsername(){
        return $this->parentUser ? $this->parentUser->username : '- no parent -';
    }
    
    /**
    * @getParentUserLink
    *
    */
    public function getParentUserLink(){
        $url = Url::to(['user/view', 'id'=>$this->parent_id]);
        $options = [];
        return Html::a($this->parentUsername, $url, $options);
    }
}
