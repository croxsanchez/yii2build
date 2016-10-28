<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\IdentificationCardInitial;

/**
 * IdentificationCardInitialSearch represents the model behind the search form about `backend\models\IdentificationCardInitial`.
 */
class IdentificationCardInitialSearch extends IdentificationCardInitial
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'identification_card_type_id'], 'integer'],
            [['initial'], 'safe'],
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
        $query = IdentificationCardInitial::find();

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
            'identification_card_type_id' => $this->identification_card_type_id,
        ]);

        $query->andFilterWhere(['like', 'initial', $this->initial]);

        return $dataProvider;
    }
}
