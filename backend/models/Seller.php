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
 * @property integer $total_points
 * @property integer $rank_value
 * @property string $rank_date
 * @property integer $credits
 *
 * @property Points[] $points
 * @property User $user
 */
class Seller extends \yii\db\ActiveRecord
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
            [['user_id', 'parent_id', 'rank_date'], 'required'],
            [['user_id', 'parent_id', 'total_points', 'rank_value', 'credits'], 'integer'],
            [['rank_date'], 'safe'],
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
            'idLink' => Yii::t('app', 'ID'),
            'userLink' => Yii::t('app', 'User ID'),
            'parentUserLink' => Yii::t('app', 'Parent ID'),
            'total_points' => Yii::t('app', 'Total Points'),
            'rankName' => Yii::t('app', 'Rank'),
            'rankDate' => Yii::t('app', 'Rank Date'),
            'credits' => Yii::t('app', 'Credits'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoints()
    {
        return $this->hasMany(Points::className(), ['seller_id' => 'id']);
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
    
    /**
    * getRank
    * line break to avoid word wrap in PDF
    * code as single line in your IDE
    */
    public function getRank(){
        return $this->hasOne(Rank::className(), ['value' =>'rank_value']);
    }
    
    /**
    * get user type name
    *
    */
    public function getRankName(){
        return $this->rank ? $this->rank->name : '- no rank -';
    }
    
    /**
    * get list of user types for dropdown
    */
    public static function getRankList(){
        $droptions = Rank::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'value', 'name');
    }
}
