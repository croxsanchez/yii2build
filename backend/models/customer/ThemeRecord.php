<?php

namespace backend\models\customer;

use Yii;
use backend\models\customer\DomainRecord;
use backend\models\customer\WebTemplateRecord;

/**
 * This is the model class for table "theme".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Domain[] $domains
 * @property WebTemplate[] $webTemplates
 */
class ThemeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomains()
    {
        return $this->hasMany(DomainRecord::className(), ['theme_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebTemplates()
    {
        return $this->hasMany(WebTemplateRecord::className(), ['theme_id' => 'id']);
    }
}
