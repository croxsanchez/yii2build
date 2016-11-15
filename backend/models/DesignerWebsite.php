<?php

namespace backend\models;

use Yii;
use backend\models\customer\Website;
use common\models\User;
use backend\models\Designer;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "designer_website".
 *
 * @property integer $designer_id
 * @property integer $website_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at 
 * @property integer $updated_by
 *
 * @property Designer $designer
 * @property User $createdBy 
 * @property User $updatedBy
 * @property Website $website
 */
class DesignerWebsite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'designer_website';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designer_id', 'website_id', 'created_by', 'updated_by'], 'required'],
            [['designer_id', 'website_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['website_id'], 'unique'],
            [['website_id'], 'unique'],
            [['designer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designer::className(), 'targetAttribute' => ['designer_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']], 
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['website_id'], 'exist', 'skipOnError' => true, 'targetClass' => Website::className(), 'targetAttribute' => ['website_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'designer_id' => 'Designer ID',
            'website_id' => 'Website ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At', 
            'updated_by' => 'Updated By',
        ];
    }

    /**
    * behaviors
    */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'blame' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ]
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesigner()
    {
        return $this->hasOne(Designer::className(), ['id' => 'designer_id']);
    }

    /**
     * get list of designers for dropdown
     */
    public static function getDesignerList(){
        $droptions = Designer::find()->select(['id','concat(first_name,\' \',last_name) AS name'])->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'name');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::className(), ['id' => 'website_id']);
    }
    
    /**
     * get list of domain choices for dropdown
     */
    public static function getWebsiteList($id){
        $droptions = Website::find()->where(['id' => $id])->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'description');
    }
}
