<?php

namespace backend\controllers;
use backend\models\customer\Customer;
use backend\models\customer\CustomerRecord;
use backend\models\customer\CustomerType;
use backend\models\customer\Phone;
use backend\models\customer\PhoneRecord;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use common\models\PermissionHelpers;
use yii\web\Controller;
use Yii;
use common\models\ValueHelpers;

class CustomersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add'],
                        'roles' => ['@'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return PermissionHelpers::requireMinimumRole('Seller') 
                                    && PermissionHelpers::requireStatus('Active');
                        }
                    ],
                    [
                        'actions' => ['index', 'query'],
                        'allow' => true
                    ],

                ]
            ]
        ];
    }


    public function actionIndex()
    {
        $records = $this->findRecordsByQuery();
        return $this->render('index', compact('records'));
    }

    public function actionAdd()
    {
        $customer = new CustomerRecord;
        $phone = new PhoneRecord;
 
        if ($this->load($customer, $phone, $_POST))
        {
            $this->store($this->makeCustomer($customer, $phone));
            $records1 = $this->getRecordsByPhoneNumber($phone->number);
            $records = $this->wrapIntoDataProvider($records1);
            return $this->render('index', compact('records'));
        }

        // stateful magic: both $customer and $phone will be validated at this point
        return $this->render('add', compact('customer', 'phone'));
    }

    public function actionQuery()
    {
        return $this->render('query');
    }

    private function store(Customer $customer)
    {
        $customer_record = new CustomerRecord();
        $customer_record->name = $customer->name;
        $customer_record->birth_date = $customer->birth_date->format('Y-m-d');
        $customer_record->notes = $customer->notes;
        $customer_record->customer_type_id = $customer->customer_type_id;

        $customer_record->save();

        foreach ($customer->phones as $phone)
        {
            $phone_record = new PhoneRecord();
            $phone_record->number = $phone->number;
            $phone_record->customer_id = $customer_record->id;
            $phone_record->save();
        }
    }

    private function makeCustomer(CustomerRecord $customer_record, PhoneRecord $phone_record)
    {
        $name = $customer_record->name;
        $birth_date = new \DateTime($customer_record->birth_date);
        $customer_type_id = $customer_record->customer_type_id;

        $customer = new Customer($name, $birth_date, $customer_type_id);
        $customer->notes = $customer_record->notes;
        $customer->phones[] = new Phone($phone_record->number);
 
        return $customer;
    }

    private function load(CustomerRecord $customer, PhoneRecord $phone, array $post)
    {
        return $customer->load($post)
            and $phone->load($post)
            and $customer->validate()
            and $phone->validate(['number']);
    }

    private function findRecordsByQuery()
    {
        $number = Yii::$app->request->get('phone_number');
        $records = $this->getRecordsByPhoneNumber($number);
        $dataProvider = $this->wrapIntoDataProvider($records);
        return $dataProvider;
    }

    private function wrapIntoDataProvider($data)
    {
        return new ArrayDataProvider(
            [
                'allModels' => $data,
                'pagination' => false
            ]
        );
    }

    private function getRecordsByPhoneNumber($number)
    {
        $phone_record = PhoneRecord::findOne(['number' => $number]);
        if (!$phone_record)
            return [];

        $customer_record = CustomerRecord::findOne($phone_record->customer_id);
        if (!$customer_record)
            return [];

        return [$this->makeCustomer($customer_record, $phone_record)];
    }
}