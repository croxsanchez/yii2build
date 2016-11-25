<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DesignerWebsite;
use backend\models\Designer;
use yii\db\Query;
/**
 * DesignerWebsiteSearch represents the model behind the search form about `backend\models\DesignerWebsite`.
 */
class DesignerWebsiteSearch extends DesignerWebsite
{
    public $designerName;
    public $designer;
    public $websiteDescription;
    public $domainName;
    public $themeName;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designer_id', 'website_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DesignerWebsite::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'designer_id' => $this->designer_id,
            'website_id' => $this->website_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
    
    public function searchMyWebsitesForDesign($params)
    {
        $designer_id = Designer::findOne(['user_id' => $params['designer_user_id']])->id;

        $query = DesignerWebsiteSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'customer_id' => [
                    'asc' => ['customer_id' => SORT_ASC],
                    'desc' => ['customer_id' => SORT_DESC],
                    'label' => 'Customer Id'
                ],
                'customerName' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => 'Full Name'
                ],
                'domainName' => [
                    'asc' => ['domain.name' => SORT_ASC],
                    'desc' => ['domain.name' => SORT_DESC],
                    'label' => 'Domain Name'
                ],
                'themeName' => [
                    'asc' => ['theme.name' => SORT_ASC],
                    'desc' => ['theme.name' => SORT_DESC],
                    'label' => 'Theme Name'
                ],
                'websiteDescription' => [
                    'asc' => ['website.description' => SORT_ASC],
                    'desc' => ['website.description' => SORT_DESC],
                    'label' => 'Website Description'
                ],
            ]
        ]);

        $query->select([
                'website_id', 
                'website.description AS websiteDescription',
                'domain.name AS domainName', 
                'theme.name AS themeName',
            ])
            ->innerJoin('website', 'website.id = website_id')
            ->innerJoin('designer', ['designer.id' => $designer_id])
            ->innerJoin('domain','domain.id = website.domain_id')
            ->innerJoin('theme','theme.id = website.theme_id')
            ->where('domain.domain_status_value=30')
            ->all();

        $this->load($params);

        return $dataProvider;
    }
    
    public function searchAssignedWebsites($params)
    {
        $query = DesignerWebsiteSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'website_id' => [
                    'asc' => ['website_id' => SORT_ASC],
                    'desc' => ['website_id' => SORT_DESC],
                    'label' => 'Id'
                ],
                'websiteDescription' => [
                    'asc' => ['website.description' => SORT_ASC],
                    'desc' => ['website.description' => SORT_DESC],
                    'label' => 'Website Description'
                ],
                'domainName' => [
                    'asc' => ['domain.name' => SORT_ASC],
                    'desc' => ['domain.name' => SORT_DESC],
                    'label' => 'Domain Name'
                ],
                'designerName' => [
                    'asc' => ['designer.first_name' => SORT_ASC],
                    'desc' => ['designer.first_name' => SORT_DESC],
                    'label' => 'Designer Name'
                ],
            ]
        ]);

        $query->select([
                'website_id', 
                'website.description AS websiteDescription',
                'domain.name AS domainName', 
                'CONCAT  (first_name, \' \', last_name) AS "designerName"', 
            ])
            ->innerJoin('website', 'website.id = website_id')
            ->innerJoin('designer','designer.id = designer_id')
            ->innerJoin('domain','domain.id = website.domain_id')
            ->where('domain.domain_status_value=30')
            ->all();

        $this->load($params);

        return $dataProvider;
    }
}
