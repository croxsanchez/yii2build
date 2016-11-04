<?php

namespace backend\models;

use common\models\User;
use backend\models\Seller;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SellerForm extends Model
{
    public $username;
    public $first_name;
    public $last_name;
    public $id_card_number;
    public $email;
    public $password;
    public $confirm_password;
    public $role_id;
    public $user_type_id;
    public $status_id;
    public $user_id;
    public $parent_id;
    public $rank_value;
    public $rank_date;
    public $total_points;
    public $credits;

    protected $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'email', 'password', 'confirm_password'], 'required', 'on' => 'create'],
            [['username', 'email'], 'required', 'on' => 'update'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password', 'passwordCriteria'],
            ['confirm_password', 'string', 'min' => 6],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
            ['id_card_number', 'required'],
            ['id_card_number', 'unique', 'targetClass' => '\backend\models\Seller', 'message' => 'This id card number has already been taken.'],
            ['role_id', 'default', 'value' => 20],
            ['user_type_id', 'default', 'value' => 10],
            [['role_id', 'user_type_id', 'status_id'], 'safe'],
        ];
    }
    
    /*
     * Función para validar criterios adicionales en la cadena de password
     * REVISAR CON CUIDADO PARA COLOCAR CRITERIOS COMPLETOS
     */
    public function passwordCriteria()
    {
        if(!empty($this->password)){
            if(strlen($this->password)<6){
                $this->addError('password','Password must contains at least six letters, one digit and one character.');
            }
            else{
                if(!preg_match('/[0-9]/',$this->password)){
                    $this->addError('password','Password must contain at least one digit.');
                }
                if(!preg_match('/[a-zA-Z]/', $this->password)){
                    $this->addError('password','Password must contain at least one character.');
                }
            }
        }
    }

    public function __construct($config = []) {
        $this->user = new User();

        parent::__construct($config);
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->role_id = $this->role_id;
            $user->user_type_id = $this->user_type_id;
            $user->status_id = $this->status_id;
            if ($user->save()){
                $seller = new Seller();
                $seller->user_id = $user->id;
                $seller->parent_id = Yii::$app->user->id;
                $seller->rank_date= $user->getCreatedAt();
                $seller->id_card_number = $this->id_card_number;
                if ($seller->save()){
                    return $seller;
                } else {
                    return null;
                }
            }
        }

        return  null;
    }

    public function isNewRecord()
    {
        return $this->user->isNewRecord;
    }
}
