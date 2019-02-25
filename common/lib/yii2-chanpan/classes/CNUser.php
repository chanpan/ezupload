<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\classes;

/**
 * Description of CNUser
 *
 * @author chanpan
 */
class CNUser {
    //put your code here
    public static function get_user_id(){
       return isset(\Yii::$app->user->id)?\Yii::$app->user->id:'';
    }
}
