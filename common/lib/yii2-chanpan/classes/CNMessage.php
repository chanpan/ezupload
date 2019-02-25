<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\classes;
use Yii;
class CNMessage {
    public static function JsonResponses(){
        return \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * 
     * @param type $message
     * @param type $data
     * @param type $action
     * @return type object
     */
    public static function getSuccess($message, $data=[], $action='create') {
        self::JsonResponses();
         
        $result = [
            'status' => 'success',
            'action' => $action,
            'message' => \cpn\chanpan\helpers\CNHtml::getMsgSuccess() . Yii::t('app', $message),
            'data'=>$data
        ];
        return $result;
    }
    /**
     * 
     * @param type $message
     * @param type $data
     * @return type object
     */
    public static function getError($message, $data=[]) {
        self::JsonResponses(); 
        $result = [
            'status' => 'error',
            'action' => 'create',
            'message' => \cpn\chanpan\helpers\CNHtml::getMsgError() . Yii::t('app', $message),
            'data'=>$data
        ];
        return $result;
    }

}
