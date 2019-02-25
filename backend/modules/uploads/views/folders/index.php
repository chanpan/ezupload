<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Folders');
$this->params['breadcrumbs'][] = $this->title;

//generator id
$btn = 'cn_btn-create-folder_' . time();
$modal = 'cn_modal-create-folder_' . time();
$model_close = 'cn_modal-create-folder_close_' . time();
$input_create_folder = 'cn_input_create_folder_'.time();
$btn_create_folder = 'cn_btn_create_folder_'.time();
$url_create = Url::to(['/uploads/folders/create']);
$url_update = Url::to(['/uploads/folders/update']);
$url_delete = Url::to(['/uploads/folders/delete']);
$url_create_file = Url::to(['/uploads/files/upload-file']);

$btn_group = 'btn_group_';
$pjax_dynamic = 'pjax_folders';
$btn_upload_file = 'cn_btn_upload_file';
$parent_id = Yii::$app->request->get('id','0');

$modal_update = 'modal_update_folder';
?>
<?php Pjax::begin(['id' => $pjax_dynamic]) ?>

<!--<div>
    
    <button onclick="$('#upload_files').click();" title="<?= Yii::t('app','Create Folder')?>" id="<?= $btn_upload_file ?>" class="btn btn-success add-show-form" 
            style="position: fixed;position: fixed;bottom: 50px;right: 50px;z-index: 9999999;border-radius: 80px;padding: 20px 24px;text-align: center;box-shadow: 0px 3px 5px #a3a3a3c9;font-size: 20px;">
        <i class="glyphicon glyphicon-plus"></i>
    </button>
</div>-->


<div class="row">
    <div class="col-md-12" style="margin-bottom:20px;">
        <div class="row" style="    z-index: 1000; background: #ecf0f5;height: 50px; border-bottom: 2px solid #dfdfdf; margin-left: 0px; margin-right: 0px;">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <label style="font-size:14pt;"><?= Yii::t('app', 'Folder') ?></label>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8 text-right">
                <div id="<?= $btn_group?>" class="pull-right">
                    <button class="btn btn-primary btn-sm btn-active btn-active-edit"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btn-sm btn-active btn-active-delete"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <div class="col-md-12" id="folder-list">
        <div class="col-md-2 text-right">
            <button title="<?= Yii::t('app','Create Folder')?>" id="<?= $btn ?>" class="" style="width: 62px;
    height: 52px;
    border: 1px #c2c2c2;
    border-style: dashed;
    border-radius: 5px;"> 
                    <i class="glyphicon glyphicon-plus"></i>
            </button>
        </div>
        <?php if($folders): ?>
            <?php foreach($folders as $k=>$v):?>
                <?= $this->render('_items_folders',['v'=>$v])?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php //file upload ?>
<?php if($parent_id != 0):?>
    <div class="row">
        <div class="col-md-12" style="margin-bottom:20px;">
            <div class="row" style="    z-index: 1000; background: #ecf0f5;height: 50px; border-bottom: 2px solid #dfdfdf; margin-left: 0px; margin-right: 0px;">
                <div class="col-md-4 col-sm-4 col-xs-4"><label style="font-size:14pt;"><?= Yii::t('app', 'Files') ?></label></div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-right">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-12" id="files-list">
            <div class="col-md-2 text-right">
                <button title="<?= Yii::t('app','Create Folder')?>" class="add-show-form <?= $btn_upload_file ?>" style="    width: 100%;
    height: 159px;
    border: 2px #c2c2c2;
    border-style: dashed;
    border-radius: 5px;
    font-size: 30pt;"> 
                        <i class="glyphicon glyphicon-plus"></i>
                </button>
            </div>
           <?php if($files): ?>
                <?php foreach($files as $k=>$v):?>
                    <?= $this->render('_items_files',['v'=>$v])?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div id="<?= $modal?>" class="modal fade" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content"> 
            <div class="modal-body">
                
                <p style="margin: 10px 0 10px 0;"><label><?= Yii::t('app', 'New Folder')?></label> <button type="button" class="close" data-dismiss="modal" style="color: #575757;opacity: 1;">&times;</button></p>
                <div style="margin:20px 0 20px 0">
                    <input id="<?= $input_create_folder?>" type="text" value="<?= Yii::t('app','Folder without name')?>" class="form-control"/>
                </div>
                
                <div class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="<?= $model_close?>"><?= Yii::t('app','Cancel')?></button>
                    <button style="padding-left: 15px;
        padding-right: 15px;" id="<?= $btn_create_folder?>" type="button" class="btn btn-primary" ><?= Yii::t('app','Create')?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= appxq\sdii\widgets\ModalForm::widget([
    'id' => $modal_update,
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    //'size'=>'modal-lg',
]);
?>

<?php 
    $this->registerCss("
       .folder_active{
          border: 1px solid #2196F3 !important;
       }
       .folder_dynamic_items{
          margin-right: 1px;background: #fff;border-radius: 5px;padding: 5px;border: 1px solid #cacaca;
       }
       #{$btn_group}{
         display:none;
       }
    ");
?>
<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    var data_id = '';
    init_func = function(){
        $('.folder_dynamic_items').click(function(){
           let id = $(this).attr('data-id');
           data_id = '';
           data_id = id;
           return false;
        });
        $('.btn-active-edit').on('click', function(){
            let url = '<?= $url_update?>?id='+data_id;
            loadModal(url);
            return false;
        });
        $('.btn-active-delete').on('click', function(){
            let url = '<?= $url_delete; ?>';
            $.post(url, {id:data_id}, function(data){
               $('#folder_dynamic_'+data_id).remove(); 
               data_id = 0;
            });
            return false;
        });
        $(this).on('click', function(){
            if(!$(this).hasClass('folder_active')){
                $(".folder_dynamic_items").each(function() { 
                    if($(this).hasClass("folder_active")){ 
                        $(this).removeClass('folder_active');
                        hide_btn_group();
                    }
               });
            }
        });//remove active class
        
        $('.folder_dynamic').dblclick(function(){
           let id = $(this).attr('data-id');
           data_id = id;
           let url = '<?= Url::to(['/uploads/folders?id='])?>'+id;
           location.href = url;
          
           return false;
        });
        $('.folder_dynamic_items').click(function(){
            $(".folder_dynamic_items").each(function() {
                    if($(this).hasClass("folder_active") || $(this).hasClass('btn-active')){
                        $(this).removeClass('folder_active');
                    }
            });
            $(this).addClass('folder_active');
            show_btn_group();
            return false;
        }); // active class

        
        $('#<?= $btn ?>').click(function () {
            $('#<?= $modal?>').modal('show');
        });

        $('#<?= $model_close ?>').click(function () {
            close_modal();
            setTimeout(function(){ clear_input(); },1000);
            return false;
        }); 
        hide_btn_group = function(){
            $('#<?= $btn_group?>').fadeOut('slow');
        }
        show_btn_group = function(){
            $('#<?= $btn_group?>').fadeIn('slow');
        }
        close_modal = function(){
            $('#<?= $modal?>').modal('hide');
        }
        clear_input = function(){
            $('#<?= $input_create_folder?>').val('<?= Yii::t('app', 'Folder without name')?>');
            return false;
        }
        return false;
    }
    
    function loadModal(url) {
        $('#<?= $modal_update?> .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#<?= $modal_update?>').modal('show')
        .find('.modal-content')
        .load(url);
    }
    $(function(){
        init_func();
    });
    
    $('#<?= $btn_create_folder ?>').click(function () {
           let folder_value = $('#<?= $input_create_folder ?>').val();
           let parent_id = '<?= $parent_id; ?>';
           $.post('<?= $url_create ?>', {folder_value:folder_value, parent_id:parent_id}, function(data){
              close_modal();
              setTimeout(function(){ 
                  clear_input();
                  $('#folder-list').prepend(data)
                  .ready(function () {
                     // location.reload();
                     //$("#reload-dev").load('http://backend.ezupload.local/uploads/folders');
                     //setTimeout(function(){init_func();},500);
                     $.pjax.reload({container: '#<?= $pjax_dynamic?>', async: false});
                  });
                  
              },1000);
           });
           return false;
        });
        
        
        //files upload
        
       $('.<?= $btn_upload_file?>').click(function(){
         let url = '<?= $url_create_file?>?folder_id='+<?= $parent_id?>;
         loadModal(url);
         return false;
       });
    
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
 <?php Pjax::end() ?>
