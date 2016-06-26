<?php

namespace backend\models\customer;

use Yii;
use backend\models\customer\ThemeRecord;

/**
 * This is the model class for table "web_template".
 *
 * @property integer $id
 * @property string $name
 * @property integer $theme_id
 * @property integer $template_purpose_value
 * @property string $path
 *
 * @property DomainTheme[] $domainThemes
 * @property Theme $theme
 */
class WebTemplateRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'theme_id', 'template_purpose_value', 'path'], 'required'],
            [['theme_id', 'template_purpose_value'], 'integer'],
            [['name', 'path'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => ThemeRecord::className(), 'targetAttribute' => ['theme_id' => 'id']],
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
            'theme_id' => 'Theme ID',
            'template_purpose_value' => 'Template Purpose Value',
            'path' => 'Path',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomainThemes()
    {
        return $this->hasMany(DomainThemeRecord::className(), ['web_template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(ThemeRecord::className(), ['id' => 'theme_id']);
    }
}
