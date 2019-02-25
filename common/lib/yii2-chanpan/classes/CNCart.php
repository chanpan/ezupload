<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\classes;

use yii\web\Session;
use Yii;
/**
 * Description of CNCart
 *
 * @author chanpan
 */
class CNCart {
    
    /**
     * 
     * @param type $id 
     * @param type $arrData
     * @param type $amount
     * @param type $action
     * @return boolean
     */
     public static function addCart($id, $arrData, $amount, $action) {
         //$amount จำนวนที่ส่งมาจาก javascript
        //$cart = isset(Yii::$app->session["cart"])?Yii::$app->session["cart"]:'';
         
//         \appxq\sdii\utils\VarDumper::dump($arrData);
        
        $session = Yii::$app->session;   
        //$id = isset($arrData['id']) ? $arrData['id'] : '';
        $name = isset($arrData['name']) ? $arrData['name'] : '';
        $detail = isset($arrData['detail']) ? $arrData['detail'] : '';
        $price = isset($arrData['price']) ? $arrData['price'] : 0;
        $image = isset($arrData['image']) ? $arrData['image'] : '';
        $size = isset($arrData['size']) ? $arrData['size'] : '';
        $qty = isset($arrData['qty'])?$arrData['qty']:'1';
        
        
        if (!isset($session["cart"])) {
            $cart[$id] = [
                'id'            =>$id,
                'pro_name'      => $name,
                'pro_detail'    => $detail,
                'pro_price'     => $price,
                'image'         => $image,                
                'amount'        => (int)$arrData['qty'],
                'sum'           => (int)$arrData['qty'] * $price,
                'size'          =>    $size
            ];
            //\appxq\sdii\utils\VarDumper::dump('001');
        } else {
            
            $cart = $session["cart"];
            if (array_key_exists($id, $cart)) {
                switch ($action) {
                    case "add":
                        //$amount เป็นจำนวนที่เก็บใน session
                        //$arrData['qty'] เป็นค่าที่ถูกส่งมาตอนเราเลือกจำนวนสินค้า
                        $cart[$id] = [
                            'id'            =>$id,
                            'pro_name'      => $name,
                            'pro_detail'    => $detail,
                            'pro_price'     => $price,
                            'image'         => $image, 
                            'amount'        => (int) $cart[$id]["amount"] + $arrData['qty'],
                            'sum'           => ((int) $cart[$id]["amount"] + $arrData['qty']) * $price,
                            'size'          =>    $size
                        ];
                       // \appxq\sdii\utils\VarDumper::dump($cart[$id]);
                        
                        break;
                    case "update":
                        //$amount เป็นจำนวนที่เก็บใน session
                        //$arrData['qty'] เป็นค่าที่ถูกส่งมาตอนเราเลือกจำนวนสินค้า
                        
                        $qty_process = 0;
                        $qty_total = 0;
                        
                        if($amount < $arrData['qty']){ //plus
                            $qty_process = $arrData['qty'] - $amount;
                            $qty_total = $amount + $qty_process;
                        }else{
                            //sub
                            $qty_process = $amount - $arrData['qty'];
                            $qty_total = $amount - $qty_process;
                        }
                       // \appxq\sdii\utils\VarDumper::dump($qty_total);
                                
                        $cart[$id] = [
                            'id'            =>$id,
                            'pro_name'      => $name,
                            'pro_detail'    => $detail,
                            'pro_price'     => $price,
                            'image'         => $image, 
                            'amount'        => (int) $qty_total,
                            'sum'           => ((int) $qty_total) * $price,
                            'size'          =>    $size
                        ];
                        break;
                    case "del":
                        //\appxq\sdii\utils\VarDumper::dump($id);
                        $cart[$id] = [
                            'id'            =>$id,
                            'pro_name'      => $name,
                            'pro_detail'    => $detail,
                            'pro_price'     => $price,
                            'image'         => $image, 
                            'amount'        => (int) $cart[$id]["amount"] - 1,
                            'sum'           => ((int) $cart[$id]["amount"] - 1) * $price,
                            'size'          =>    $size
                        ];
                        break;
                }
            } else {
                
                //1546573267079062200
                //1546569431030593700
                $cart[$id] = [
                    'id'            =>$id,
                    'pro_name'      => $name,
                    'pro_detail'    => $detail,
                    'pro_price'     => $price,
                    'image'         => $image, 
                    'amount'        => (int)$qty,
                    'sum'           => $qty * $price,
                    'size'          =>    $size
                ];
            }
        }
        $session["cart"] = $cart;
        return true;
        // $session->destroy();
    }

    public static function sumCart() {
        $sum = 0;
        foreach (Yii::$app->session["cart"] as $key => $value) {
            $sum += $value["pro_price"];
        }
        return $sum;
    }
}
