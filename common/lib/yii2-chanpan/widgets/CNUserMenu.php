<?php
namespace cpn\chanpan\widgets;
use Yii;
class CNUserMenu extends \dektrium\user\widgets\UserMenu{
    public $items;
    public $menu_type;
    
    public function init()
    {
        parent::init();
        
        $moduleId = (isset(Yii::$app->controller->module->id) && Yii::$app->controller->module->id != 'app-backend') ? Yii::$app->controller->module->id : '';
        $controllerId = isset(Yii::$app->controller->id) ? Yii::$app->controller->id : '';
        $actionId = isset(Yii::$app->controller->action->id) ? Yii::$app->controller->action->id : '';
        $viewId = \Yii::$app->request->get('id', '');
        //\appxq\sdii\utils\VarDumper::dump($controllerId);
        //$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
        if(isset($this->menu_type) && $this->menu_type == 'setting'){
            $this->items = [
                [
                    'label' => Yii::t('user', '<i class=""></i> Routing'), 
                    'url' => ['/admin/route'],
                    'active'=>($controllerId == 'route') ? true : false
                ],
                [
                    'label' => Yii::t('user', '<i class=""></i> Role'),
                    'url' => ['/admin/role'],
                    'active'=>($controllerId == 'role')? true : false
                ],
                [
                    'label' => Yii::t('user', '<i class=""></i> Permission'), 
                    'url' => ['/admin/permission'],
                    'active'=>($controllerId == 'permission')? true : false
                ],
                [
                    'label' => Yii::t('user', '<i class=""></i> Assignment'), 
                    'url' => ['/admin'],
                    'active'=>($controllerId == 'assignment')? true : false
                ],
            ];
        }else{
            $this->items = [
                ['label' => Yii::t('user', '<i class="fa fa-user"></i> ข้อมูลส่วนตัว'), 'url' => ['/user/settings/profile']],
                ['label' => Yii::t('user', '<i class="fa fa-id-card-o"></i> บัญชี'), 'url' => ['/user/settings/account']],
                ['label' => Yii::t('user', '<i class="fa fa-map-marker"></i> ที่อยู่จัดส่ง'), 'url' => ['/user/settings/shipping-addresses']],
                ['label' => Yii::t('user', '<i class="fa fa-file"></i> รวมใบเสนอราคา'), 'url' => ['/user/settings/quotation-histories']],
                ['label' => Yii::t('user', '<i class="fa fa-file"></i> รวมใบสั่งซื้อ'), 'url' => ['/user/settings/order-histories']],
                ['label' => '<i class="fa fa-sign-out"></i> '.Yii::t('appmenu', 'Logout'), 'encode' => FALSE,'url' => ['/user/security/logout'] , 'options'=>['class'=>'btnLogout', 'data-method' => 'post', 'data-url'=>'/user/security/logout' ]],
            ];
        }
            
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
