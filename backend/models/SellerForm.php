<?php

namespace backend\models;

use common\models\user;
use backend\models\Seller;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SellerForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role_id;
    public $user_type_id;
    public $status_id;

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
            [['role_id', 'user_type_id', 'status_id'], 'safe'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }
        
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
            $seller->save();
            return $user;
        } 
        
        return  null;
    }
}
