<?php

namespace backend\models\customer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\customer\Website;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * WebsiteSearch represents the model behind the search form about `backend\models\customer\Website`.
 */
class WebsiteSearch extends Website
{
    public $customerName;
    public $paymentStatus;
    public $domainChoiceOrder;
    public $name;
    public $domainName;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'theme_id', 'payment_method_value', 'created_by', 'updated_by', 'payment_status_value', 'domain_id'], 'integer'],
            [['description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Website::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'paymentMethodName' => [
                    'asc' => ['payment_method_value' => SORT_ASC],
                    'desc' => ['payment_method_value' => SORT_DESC],
                    'label' => 'Payment Method'
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'theme_id' => $this->theme_id,
            'payment_method_value' => $this->payment_method_value, 
            'created_at' => $this->created_at, 
            'created_by' => $this->created_by, 
            'updated_at' => $this->updated_at, 
            'updated_by' => $this->updated_by, 
            'payment_status_value' => $this->payment_status_value, 
            'domain_id' => $this->domain_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
    
    public function searchWebsitesPendingForFirstPayment()
    {
        //$query = WebsiteSearch::find();
        $query = new Query();
        
        /*$dataProvider = new SqlDataProvider([
            'sql' => 'SELECT website.id AS id, customer.id AS customer_id, customer.name AS customerName, description, pre_domain.name, domain_choice.order, (SELECT name FROM payment_status WHERE value=10) AS paymentStatus 
                    FROM website
                    INNER JOIN pre_domain
                    ON pre_domain.website_id = website.id
                    INNER JOIN domain_choice
                    ON domain_choice.value = pre_domain.domain_choice_value
                    INNER JOIN customer 
                    ON customer.id = website.customer_id
                    WHERE website.payment_status_value = :value',
            'params' => [':value' => 10],
        ]);*/
        
        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));
        
        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'label' => 'Id'
                ],
                'website.customer_id' => [
                    'asc' => ['customer_id' => SORT_ASC],
                    'desc' => ['customer_id' => SORT_DESC],
                    'label' => 'Customer Id'
                ],
                'customerName' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => 'Full Name'
                ],
                'name' => [
                    'asc' => ['pre_domain.name' => SORT_ASC],
                    'desc' => ['pre_domain.name' => SORT_DESC],
                    'label' => 'Domain Name'
                ],
                'pre_domain.domainChoiceOrder' => [
                    'asc' => ['pre_domain.domain_choice_value' => SORT_ASC],
                    'desc' => ['pre_domain.domain_choice_value' => SORT_DESC],
                    'label' => 'Domain Name Preference'
                ],
                'paymentStatus' => [
                    'asc' => ['website.payment_status_value' => SORT_ASC],
                    'desc' => ['website.payment_status_value' => SORT_DESC],
                    'label' => 'Payment Status'
                ],
            ]
        ]);
        
        
        $subQuery = (new Query())->select('name')
                                ->from('payment_status')
                                ->where(['value' => 10]);
        
        $query->select(['website.id AS id', 'website.customer_id', 'customer.name AS customerName', 'website.description','pre_domain.name','domain_choice.order AS domainChoiceOrder' ,'paymentStatus' => $subQuery])
            ->from('website')
            ->innerJoin('pre_domain', 'pre_domain.website_id = website.id')
            ->innerJoin('domain_choice','pre_domain.domain_choice_value = domain_choice.value')
            ->innerjoin('customer', 'website.customer_id = customer.id')
            ->where(['website.payment_status_value' => 10])
            ->orderBy('website.id')
            ->all();
        
        //$this->load($params);
        
        return $dataProvider;
    }
    
    public function searchMyWebsitesForDevelopment($params)
    {
        $query = WebsiteSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    'label' => 'Id'
                ],
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
                'paymentStatus' => [
                    'asc' => ['domain.payment_status_value' => SORT_ASC],
                    'desc' => ['domain.payment_status_value' => SORT_DESC],
                    'label' => 'Payment Status'
                ],
            ]
        ]);


        /*$subQuery = (new Query())->select('name')
                                ->from('domain_status')
                                ->where(['value' => 20]);*/

        $query->select(['website.id AS id', 'website.customer_id', 'customer.name AS customerName', 'domain.name AS domainName'])
            ->innerJoin('customer', 'website.customer_id = customer.id')
            ->innerJoin('domain','domain.id = website.domain_id')
            ->where(['website.created_by' => $params['seller_user_id']])
            ->andWhere(['payment_status_value' => 20])
            ->andWhere(['domain.domain_status_value' => 20])
            ->all();

        $this->load($params);

        return $dataProvider;
    }
    
    public function searchMyPublishedWebsites($params)
    {
        $query = WebsiteSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['website.id' => SORT_ASC],
                    'desc' => ['website.id' => SORT_DESC],
                    'label' => 'Website Id'
                ],
                'name' => [
                    'asc' => ['domain.name' => SORT_ASC],
                    'desc' => ['domain.name' => SORT_DESC],
                    'label' => 'Domain Name'
                ],
                'description' => [
                    'asc' => ['description' => SORT_ASC],
                    'desc' => ['description' => SORT_DESC],
                    'label' => 'Website Description'
                ],
                'customerName' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => 'Full Name'
                ],
                'paymentStatus' => [
                    'asc' => ['domain.payment_status_value' => SORT_ASC],
                    'desc' => ['domain.payment_status_value' => SORT_DESC],
                    'label' => 'Payment Status'
                ],
            ]
        ]);

        $subQuery = (new Query())->select('name')
                                ->from('payment_status')
                                ->where(['value' => 20]);

        $query->select(['website.id', 'domain.name', 'website.description','customer.name AS customerName', 'paymentStatus' => $subQuery])
            ->innerJoin('customer', 'website.customer_id = customer.id')
            ->innerJoin('domain', 'domain.id = website.domain_id')
            ->where(['website.created_by' => $params['seller_user_id']])
            ->andWhere(['website.payment_status_value' => 30])
            ->andwhere(['domain.domain_status_value' => 50])
            ->all();

        $this->load($params);

        return $dataProvider;
    }
}
