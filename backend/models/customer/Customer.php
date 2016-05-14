<?php

namespace backend\models\customer;


class Customer {
    /** @var string */
    public $name;

    /** @var \DateTime */
    public $birth_date;

    /** @var string */
    public $notes = '';
    
    /** @var integer */
    public $customer_type_id;

    /** @var PhoneRecord[] */
    public $phones = [];

    public function __construct($name, $birth_date, $customer_type_id=10)
    {
        $this->name = $name;
        $this->birth_date = $birth_date;
        $this->customer_type_id = $customer_type_id;
    }

} 