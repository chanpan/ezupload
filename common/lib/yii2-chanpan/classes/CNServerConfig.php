<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\classes;

/**
 * Description of CNServerConfig
 *
 * @author chanpan
 */
class CNServerConfig {
    
    /**
     * 
     * @return boolean
     */
    public static function isBackend(){
        $domain = self::getDomainName();
        $backend_url = isset(\Yii::$app->params['backend_url'])?\Yii::$app->params['backend_url']:'';
        if($domain == $backend_url){
            return true;
        }
        return false;
    }
    /**
     * 
     * @return type string
     */
    public static function getDomainName() {
        return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
    }
}
