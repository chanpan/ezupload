<?php
namespace cpn\chanpan\widgets;
use Yii;
class CNSettingMenu extends \dektrium\user\widgets\UserMenu{
    public $items;
    public $menu_type;
    
    public function init()
    {
        parent::init();
        
        $moduleId = (isset(Yii::$app->controller->module->id) && Yii::$app->controller->module->id != 'app-backend') ? Yii::$app->controller->module->id : '';
        $controllerId = isset(Yii::$app->controller->id) ? Yii::$app->controller->id : '';
        $actionId = isset(Yii::$app->controller->action->id) ? Yii::$app->controller->action->id : '';
        $viewId = \Yii::$app->request->get('id', '');
         
        $this->items = [
//            [
//                'label' => Yii::t('setting', '<i class=""></i> แจ้งชำระเงิน'),
//                'url' => ['/payments'],
//                'active' => ($controllerId == 'payments') ? true : false
//            ],
            [
                'label' => Yii::t('setting', '<i class=""></i> ธนาคาร'),
                'url' => ['/payment-types'],
                'active' => ($controllerId == 'payment-types') ? true : false
            ],
            [
                'label' => Yii::t('setting', '<i class=""></i> เกี่ยวกับเรา'),
                'url' => ['/site/about'],
                'active' => ($controllerId == 'site' && $actionId == 'about') ? true : false
            ],
            [
                'label' => Yii::t('setting', '<i class=""></i> ติดต่อเรา'),
                'url' => ['/site/contact'],
                'active' => ($controllerId == 'site' && $actionId == 'contact') ? true : false
            ],
            [
                'label' => Yii::t('user', '<i class=""></i> เงื่อนไขการสั่งซื้อ'),
                'url' => ['/order-conditions/index'],
                'active' => ($controllerId == 'order-conditions') ? true : false
            ],
            [
                'label' => Yii::t('user', '<i class=""></i> วิธีการสั่งซื้อ'),
                'url' => ['/site/how-to-pay'],
                'active' => ($controllerId == 'site' && $actionId=='how-to-pay' ) ? true : false
            ],
            [
                'label' => Yii::t('user', '<i class=""></i> ภาพ Slider'),
                'url' => ['/sliders'],
                'active' => ($controllerId == 'sliders') ? true : false
            ],
            [
                'label' => Yii::t('user', '<i class=""></i> Core Options'),
                'url' => ['/core-option'],
                'active' => ($controllerId == 'core-option') ? true : false
            ],
        ];
    }
    public function run()
    {
        $js="
            $('.btnLogout').on('click', function(){
                let url = $(this).attr('data-url');
                yii.confirm('ต้องการออกจากระบบ?', function() {
                    $.post(url, function(data){
                        console.log(data);
                    });
                });

                
                return false;
            });
        ";
        $css="
          .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
                color: #666;
                background-color: #f1f2f4;
                border-left: 5px solid #e5493d;
            }  
            .nav-pills > li > a {
                border-radius: 0px;
            }
        ";
        $view = $this->getView();
        $view->registerJs($js);
        $view->registerCss($css);
        return \yii\widgets\Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
                
            ],
            'encodeLabels' => false,
            'items' => $this->items,
        ]);
    }
}
