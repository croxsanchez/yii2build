<?php

namespace backend\models\customer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\customer\DomainRecord;
use yii\db\Query;

/**
 * DomainRecordSearch represents the model behind the search form about `backend\models\customer\DomainRecord`.
 */
class DomainRecordSearch extends DomainRecord
{
    public $customerName;
    public $paymentStatus;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'domain_choice_value', 'payment_status_value', 'domain_status_value', 'theme_id', 'created_by', 'updated_by', 'payment_method_value'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
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
        $query = DomainRecord::find();

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
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'domain_choice_value' => $this->domain_choice_value,
            'payment_status_value' => $this->payment_status_value,
            'domain_status_value' => $this->domain_status_value,
            'theme_id' => $this->theme_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'payment_method_value' => $this->payment_method_value,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
    public function searchMyDomainsPendingForFirstPayment()
    {
        $query = DomainRecordSearch::find();

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
                'name' => [
                    'asc' => ['domain.name' => SORT_ASC],
                    'desc' => ['domain.name' => SORT_DESC],
                    'label' => 'Domain Name'
                ],
                'domainChoiceOrder' => [
                    'asc' => ['domain.domain_choice_value' => SORT_ASC],
                    'desc' => ['domain.domain_choice_value' => SORT_DESC],
                    'label' => 'Domain domain_choice_value'
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
                                ->where(['value' => 10]);

        $query->select(['domain.id AS id', 'customer_id', 'customer.name AS customerName', 'domain.name','domain.domain_choice_value' ,'paymentStatus' => $subQuery])
            ->innerjoin('customer', 'domain.customer_id = customer.id')
            ->where(['payment_status_value' => 10])
            ->all();

        //$this->load($params);

        return $dataProvider;
    }
    
    public function searchMyDomainsForDevelopment($params)
    {
        $query = DomainRecordSearch::find();

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
                'name' => [
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

        $query->select(['domain.id AS id', 'customer_id', 'customer.name AS customerName', 'domain.name'])
            ->innerjoin('customer', 'domain.customer_id = customer.id')
            ->where(['domain.created_by' => $params['seller_user_id']])
            ->andWhere(['payment_status_value' => 20])
            ->innerJoin(['ds' => 'domain_status'], 'domain.domain_status_value = ds.value')
            ->all();

        $this->load($params);

        return $dataProvider;
    }
    
    public function searchMyPaidOutDomains($params)
    {
        $query = DomainRecordSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['domain.id' => SORT_ASC],
                    'desc' => ['domain.id' => SORT_DESC],
                    'label' => 'Domain Id'
                ],
                'name' => [
                    'asc' => ['domain.name' => SORT_ASC],
                    'desc' => ['domain.name' => SORT_DESC],
                    'label' => 'Domain Name'
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

        $query->select(['domain.id', 'domain.name', 'customer.name AS customerName', 'paymentStatus' => $subQuery])
            ->innerjoin('customer', 'domain.customer_id = customer.id')
            ->where(['domain.created_by' => $params['seller_user_id']])
            ->andWhere(['domain.payment_status_value' => 20])
            ->all();

        $this->load($params);

        return $dataProvider;
    }
}
