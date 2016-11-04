<?php

namespace backend\models\customer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\customer\CustomerRecord;
use yii\db\Query;

/**
 * CustomerRecordSearch represents the model behind the search form about `backend\models\customer\CustomerRecord`.
 */
class CustomerRecordSearch extends CustomerRecord
{

    public $country;
    public $domainName;
    public $paymentStatus;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_type_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'birth_date', 'notes', 'created_at', 'updated_at', 'country', 'domainName'], 'safe'],
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
        $query = CustomerRecord::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('addresses');
        $dataProvider->sort->attributes['country'] = [
            'asc' => ['address.country' => SORT_ASC],
            'desc' => ['address.country' => SORT_DESC]
        ];

        $query->joinWith('emails');
        $dataProvider->sort->attributes['email'] = [
        'asc' => ['email.address' => SORT_ASC],
        'desc' => ['email.address' => SORT_DESC],
        ];

        $query->joinWith('phones');
        $dataProvider->sort->attributes['phone'] = [
            'asc' => ['phone.number' => SORT_ASC],
            'desc' => ['phone.number' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'customer.id' => $this->id,
            'birth_date' => $this->birth_date,
            'customer_type_id' => $this->customer_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        $query->andFilterWhere(['like', 'address.country',$this->country]);


        return $dataProvider;
    }


    public function searchMyCustomers($params)
    {
        $query = CustomerRecord::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

        $query->joinWith('addresses');
        $dataProvider->sort->attributes['country'] = [
            'asc' => ['address.country' => SORT_ASC],
            'desc' => ['address.country' => SORT_DESC]
        ];

        $query->joinWith('emails');
        $dataProvider->sort->attributes['email'] = [
        'asc' => ['email.address' => SORT_ASC],
        'desc' => ['email.address' => SORT_DESC],
        ];

        $query->joinWith('phones');
        $dataProvider->sort->attributes['phone'] = [
            'asc' => ['phone.number' => SORT_ASC],
            'desc' => ['phone.number' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->where(['created_by' => $params['seller_user_id']]);

        $query->andFilterWhere([
            'customer.id' => $this->id,
            'birth_date' => $this->birth_date,
            'customer_type_id' => $this->customer_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        $query->andFilterWhere(['like', 'address.country',$this->country]);
        
        /*$query = CustomerRecord::find();

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
                    'label' => 'Customer'
                ],
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'label' => 'Name'
                ],
                'birth_date' => [
                    'asc' => ['birth_date' => SORT_ASC],
                    'desc' => ['birth_date' => SORT_DESC],
                    'label' => 'Birth Date'
                ],
            ]
        ]);

        $query->select(['id', 'name', 'birth_date'])
            ->where(['created_by' => $params['seller_user_id']])
            ->all();

        $this->load($params);*/

        return $dataProvider;
    }

    public function searchMyPendingForPayment($params)
    {
        $query = CustomerRecordSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['customer.id' => SORT_ASC],
                    'desc' => ['customer.id' => SORT_DESC],
                    'label' => 'Customer'
                ],
                'name' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => 'Name'
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

        $subQuery = (new Query())->select('name')
                                ->from('payment_status')
                                ->where(['value' => 10]);

        $query->select(['customer.id', 'customer.name', 'domain.name AS domainName', 'paymentStatus' => $subQuery])
            ->innerjoin('domain', 'domain.customer_id = customer.id')
            ->where(['customer.created_by' => $params['seller_user_id']])
            ->andWhere(['domain.payment_status_value' => 10])
            ->all();

        $this->load($params);

        return $dataProvider;
    }

    public function searchMyPaidOutCustomers($params)
    {
        $query = CustomerRecordSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['customer.id' => SORT_ASC],
                    'desc' => ['customer.id' => SORT_DESC],
                    'label' => 'Customer'
                ],
                'name' => [
                    'asc' => ['customer.name' => SORT_ASC],
                    'desc' => ['customer.name' => SORT_DESC],
                    'label' => 'Name'
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

        $subQuery = (new Query())->select('name')
                                ->from('payment_status')
                                ->where(['value' => 20]);

        $query->select(['customer.id', 'customer.name', 'domain.name AS domainName', 'paymentStatus' => $subQuery])
            //->from('customer')
            ->innerjoin('domain', 'domain.customer_id = customer.id')
            ->where(['customer.created_by' => $params['seller_user_id']])
            ->andWhere(['domain.payment_status_value' => 20])
            ->all();

        $this->load($params);

        return $dataProvider;
    }

    protected function addSearchParameter($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        $value = $this->$modelAttribute;

        if (trim($value) === '') {
            return;
        }

        /*
        * The following line is additionally added for right aliasing
        * of columns so filtering happen correctly in the self join
        */
        $attribute = "customer.$attribute";

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
