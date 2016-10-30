<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Seller;

/**
 * SellerSearch represents the model behind the search form about `backend\models\Seller`.
 */
class SellerSearch extends Seller
{
    public $username;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'parent_id', 'total_points', 'rank_value', 'credits'], 'integer'],
            [['rank_date'], 'safe'],
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
        $query = Seller::find();

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
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'total_points' => $this->total_points,
            'rank_value' => $this->rank_value,
            'rank_date' => $this->rank_date,
            'credits' => $this->credits,
        ]);

        return $dataProvider;
    }
    
    public function searchMyOrganization($params)
    {
        $query = Seller::find();

        // add conditions that should always apply here

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $query->joinWith('user');
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //$query->where(['parent_id' => $params['seller_user_id']]);

        $query->andFilterWhere([
            'id' => $this->id,
            'user.username' => $this->username,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'total_points' => $this->total_points,
            'rank_value' => $this->rank_value,
            'rank_date' => $this->rank_date,
            'credits' => $this->credits,
        ]);

       /* $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'notes', $this->notes]);
        * 
        */

        $query->andFilterWhere(['like', 'user.username',$this->username]);
        
        /*$query = CustomerRecord::find();*/

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['seller.id' => SORT_ASC],
                    'desc' => ['seller.id' => SORT_DESC],
                    'label' => 'Seller'
                ],
                'userLink' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                    'label' => 'User Name'
                ],
                'user_id' => [
                    'asc' => ['user_id' => SORT_ASC],
                    'desc' => ['user_id' => SORT_DESC],
                    'label' => 'User Id'
                ],
                'rank_value' => [
                    'asc' => ['rank_value' => SORT_ASC],
                    'desc' => ['rank_value' => SORT_DESC],
                    'label' => 'Rank Value'
                ],
                'rank_date' => [
                    'asc' => ['rank_date' => SORT_ASC],
                    'desc' => ['rank_date' => SORT_DESC],
                    'label' => 'Rank Date'
                ],
                'total_points' => [
                    'asc' => ['total_points' => SORT_ASC],
                    'desc' => ['total_points' => SORT_DESC],
                    'label' => 'Total Points'
                ],
                'credits' => [
                    'asc' => ['credits' => SORT_ASC],
                    'desc' => ['credits' => SORT_DESC],
                    'label' => 'Credits'
                ],
            ]
        ]);

        $query->select(['seller.id', 'parent_id','user.username','user_id', 'rank_value', 'rank_date', 'total_points', 'credits'])
            ->where(['parent_id' => $params['seller_user_id']])
            ->all();

        //$this->load($params);
        $query->andFilterWhere(['like', 'user.name',$this->username]);

        return $dataProvider;
    }

    
}
