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
    public $ident_card_id;
    public $ident_card_init_id;
    public $ident_card_number;
    public $email;
    public $password;
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
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['ident_card_id', 'ident_card_init_id', 'ident_card_number'], 'required'],
            ['role_id', 'default', 'value' => 20],
            ['user_type_id', 'default', 'value' => 10],
            [['role_id', 'user_type_id', 'status_id'], 'safe'],
        ];
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
                if ($seller->save()){
                    return $seller;
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
