<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Profile;

class ProfileSearch extends Profile
{
    /*public $genderName;
    public $gender_id;*/
    public $sellerId;
    public function rules()
    {
        return [
            [['id', 'gender_id'], 'integer'],
            [['first_name', 'last_name', 'birth_date', 'genderName','userId', 'filename', 'avatar'], 'safe'],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'gender_id' => 'Gender',
            ];
    }
    
    public function search($params)
    {
        $query = Profile::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'first_name',
                'last_name',
                'birth_date',
                /*'genderName' => [
                    'asc' => ['gender.gender_name' => SORT_ASC],
                    'desc' => ['gender.gender_name' => SORT_DESC],
                    'label' => 'Gender'
                ],*/
                'profileIdLink' => [
                    'asc' => ['profile.id' => SORT_ASC],
                    'desc' => ['profile.id' => SORT_DESC],
                    'label' => 'ID'
                ],
                'userLink' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                    'label' => 'User'
                ],
            ]
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            $query/*->joinWith(['gender'])*/
                    ->joinWith(['seller']);
            return $dataProvider;
        }
        
        $this->addSearchParameter($query, 'profile.id');
        $this->addSearchParameter($query, 'first_name', true);
        $this->addSearchParameter($query, 'last_name', true);
        $this->addSearchParameter($query, 'birth_date');
        //$this->addSearchParameter($query, 'gender_id');
        $this->addSearchParameter($query, 'created_at');
        $this->addSearchParameter($query, 'updated_at');
        $this->addSearchParameter($query, 'seller_id');
   
        // filter by gender name
        $query/*->joinWith(['gender' => function ($q) {
            $q->where('gender.gender_name LIKE "%' . $this->genderName . '%"');
        }])*/
        
        // filter by profile
            ->joinWith(['seller' => function ($q) {
                $q->where('seller.id LIKE "%' . $this->sellerId . '%"');
            }]);
            
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
        $attribute = "profile.$attribute";
        
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}