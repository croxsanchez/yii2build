<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

/**
 * Description of ValueHelpers
 *
 * @author crox
 */
class ValueHelpers {
    /**
    * return the value of a role name handed in as string
    * example: 'Admin'
    *
    * @param mixed $role_name
    */
    public static function getRoleValue($role_name){
        $connection = \Yii::$app->db;
        $sql = "SELECT role_value FROM role WHERE role_name=:role_name";
        $command = $connection->createCommand($sql);
        $command->bindValue(":role_name", $role_name);
        $result = $command->queryOne();
        return $result['role_value'];
    }
    
    /**
    * return the value of a status name handed in as string
    * example: 'Active'
    * @param mixed $status_name
    */
    public static function getStatusValue($status_name){
        $connection = \Yii::$app->db;
        $sql = "SELECT status_value FROM status WHERE status_name=:status_name";
        $command = $connection->createCommand($sql);
        $command->bindValue(":status_name", $status_name);
        $result = $command->queryOne();
        return $result['status_value'];
    }

    /**
    * returns value of user_type_name so that you can
    * used in PermissionHelpers methods
    * handed in as string, example: 'Paid'
    *
    * @param mixed $user_type_name
    */
    public static function getUserTypeValue($user_type_name){
        $connection = \Yii::$app->db;
        $sql = "SELECT user_type_value FROM user_type
        WHERE user_type_name=:user_type_name";
        $command = $connection->createCommand($sql);
        $command->bindValue(":user_type_name", $user_type_name);
        $result = $command->queryOne();
        return $result['user_type_value'];
    }
    
    /**
    * returns value of customer_type_name so that you can
    * used in PermissionHelpers methods
    * handed in as string, example: 'Natural'
    *
    * @param mixed $customer_type_name
    */
    public static function getCustomerTypeValue($customer_type_name){
        $connection = \Yii::$app->db;
        $sql = "SELECT customer_type_value FROM customer_type
        WHERE customer_type_name=:customer_type_name";
        $command = $connection->createCommand($sql);
        $command->bindValue(":customer_type_name", $customer_type_name);
        $result = $command->queryOne();
        return $result['customer_type_value'];
    }
    
    /**
    * return the value of a rank name handed in as string
    * example: 'Agente'
    * @param mixed $rank_name
    */
    public static function getRankValue($rank_name){
        $connection = \Yii::$app->db;
        $sql = "SELECT value FROM rank WHERE name=:rank_name";
        $command = $connection->createCommand($sql);
        $command->bindValue(":rank_name", $rank_name);
        $result = $command->queryOne();
        return $result['value'];
    }
}
