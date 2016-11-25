<?php

namespace backend\models\customer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\customer\PublishedSite;
use backend\models\Seller;

/**
 * PublishedSiteSearch represents the model behind the search form about `backend\models\customer\PublishedSite`.
 */
class PublishedSiteSearch extends PublishedSite
{
    public $websiteDescription;
    public $domainName;
    public $themeName;
    public $customerName;

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
        $query = PublishedSite::find();

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
    
    public function searchMyTemporaryPublishedWebsites($params)
    {
        $seller_id = Seller::findOne(['user_id' => $params['seller_user_id']])->id;

        $query = PublishedSiteSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['published_site.id' => SORT_ASC],
                    'desc' => ['published_site.id' => SORT_DESC],
                    'label' => 'Id'
                ],
                'website_id' => [
                    'asc' => ['website_id' => SORT_ASC],
                    'desc' => ['website_id' => SORT_DESC],
                    'label' => 'Website Id'
                ],
                'url' => [
                    'asc' => ['url' => SORT_ASC],
                    'desc' => ['url' => SORT_DESC],
                    'label' => 'URL'
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
                'published_site.id',
                'website_id', 
                'website.description AS websiteDescription',
                'url',
                'url_status',
                'domain.name AS domainName', 
                'theme.name AS themeName',
                'customer.name AS customerName',
            ])
            ->innerJoin('website', 'website.id = website_id')
            ->innerJoin('seller', ['seller.id' => $seller_id]) // This seller
            ->innerJoin('domain','domain.id = website.domain_id')
            ->innerJoin('theme','theme.id = website.theme_id')
            ->innerJoin('customer','customer.id = published_site.customer_id')
            ->where('domain.domain_status_value=40')
            ->all();

        $this->load($params);

        return $dataProvider;
    }
    
    public function searchMyPublishedWebsites($params)
    {
        $seller_id = Seller::findOne(['user_id' => $params['seller_user_id']])->id;

        $query = PublishedSiteSearch::find();

        $dataProvider = (new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                    'pageSize' => 10,
                ],
            ]));

        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'asc' => ['published_site.id' => SORT_ASC],
                    'desc' => ['published_site.id' => SORT_DESC],
                    'label' => 'Id'
                ],
                'website_id' => [
                    'asc' => ['website_id' => SORT_ASC],
                    'desc' => ['website_id' => SORT_DESC],
                    'label' => 'Website Id'
                ],
                'url' => [
                    'asc' => ['url' => SORT_ASC],
                    'desc' => ['url' => SORT_DESC],
                    'label' => 'URL'
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
                'published_site.id',
                'website_id', 
                'website.description AS websiteDescription',
                'url',
                'url_status',
                'domain.name AS domainName', 
                'theme.name AS themeName',
                'customer.name AS customerName',
            ])
            ->innerJoin('website', 'website.id = website_id')
            ->innerJoin('seller', ['seller.id' => $seller_id]) // This seller
            ->innerJoin('domain','domain.id = website.domain_id')
            ->innerJoin('theme','theme.id = website.theme_id')
            ->innerJoin('customer','customer.id = published_site.customer_id')
            ->where('domain.domain_status_value=70')
            ->all();

        $this->load($params);

        return $dataProvider;
    }
}
