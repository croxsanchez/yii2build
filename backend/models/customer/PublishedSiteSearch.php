<?php

namespace backend\models\customer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\customer\TemporarySite;

/**
 * TemporarySiteSearch represents the model behind the search form about `backend\models\customer\TemporarySite`.
 */
class TemporarySiteSearch extends TemporarySite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'website_id', 'designer_id', 'seller_id', 'customer_id', 'created_by', 'updated_by'], 'integer'],
            [['url', 'created_at', 'updated_at'], 'safe'],
            [['url_status'], 'boolean'],
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
        $query = TemporarySite::find();

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
            'url_status' => $this->url_status,
            'website_id' => $this->website_id,
            'designer_id' => $this->designer_id,
            'seller_id' => $this->seller_id,
            'customer_id' => $this->customer_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
