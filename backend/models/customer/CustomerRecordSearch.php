<?php

namespace backend\models\customer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\customer\CustomerRecord;

/**
 * CustomerRecordSearch represents the model behind the search form about `backend\models\customer\CustomerRecord`.
 */
class CustomerRecordSearch extends CustomerRecord
{
    
    public $country;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_type_id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'birth_date', 'notes', 'created_at', 'updated_at', 'country'], 'safe'],
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
}
