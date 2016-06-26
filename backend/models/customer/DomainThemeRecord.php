<?php

namespace backend\models\customer;

use Yii;
use backend\models\customer\DomainRecord;
use backend\models\customer\WebTemplateRecord;

/**
 * This is the model class for table "domain_theme".
 *
 * @property integer $id
 * @property integer $domain_id
 * @property integer $web_template_id
 *
 * @property Domain $domain
 * @property WebTemplate $webTemplate
 */
class DomainThemeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'domain_theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['domain_id', 'web_template_id'], 'required'],
            [['domain_id', 'web_template_id'], 'integer'],
            [['domain_id'], 'exist', 'skipOnError' => true, 'targetClass' => DomainRecord::className(), 'targetAttribute' => ['domain_id' => 'id']],
            [['web_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebTemplateRecord::className(), 'targetAttribute' => ['web_template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain_id' => 'Domain ID',
            'web_template_id' => 'Web Template ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(DomainRecord::className(), ['id' => 'domain_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebTemplate()
    {
        return $this->hasOne(WebTemplateRecord::className(), ['id' => 'web_template_id']);
    }
}
