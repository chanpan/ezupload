<?php 
    use yii\helpers\Html;
    kartik\file\FileInputAsset::register($this);
?>
<div class="modal-body">
   
    <div class="file-loading">
        <input id="input-700" name="name[]" type="file" multiple accept="">
    </div>
</div>
<div class="modal-footer">
    <div class="pull-right">
        <?= Html::submitButton(Yii::t('app','Close'),['class'=>'btn btn-danger btn-block btnClose', 'data-dismiss'=>'modal']) ?>
    </div>
</div>
<?php \richardfan\widget\JSRegister::begin();?>
<script>
    $('.btnSubmit').prop('disabled', true); 
    
    $("#input-700").fileinput({        
        uploadUrl: "<?= yii\helpers\Url::to(['/uploads/files/upload-file'])?>",
        minFileCount:0,
        maxFileCount:1000,
        showUpload:false,
        showRemove:false,
        uploadExtraData: function() {
            return {
                folder_id: '<?= $folder_id?>',
            };
        },
        //ajaxSettings: { headers: { Authorization: 'Bearer ' + localStorageService.get('authorizationData').token } }    
    }).on("filebatchselected", function(event, files) {
        $("#input-700").fileinput("upload");
        $('.btnClose').prop('disabled', true);
    }).on('filebatchuploadcomplete', function (event, data, previewId, index) {
          let result = {message:'Upload success', status:'success'};
          <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
          $(document).find('#modal_update_folder').modal('hide');    
          $('.btnClose').prop('disabled', false);
          setTimeout(function(){
             $.pjax.reload({container:'#pjax_folders'});  
          },1000);  
    }).on('filebatchuploaderror', function (event, data, previewId, index) {
          let result = {message:'Upload error', status:'error'};
          <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status') ?>
          $(document).find('#modal_update_folder').modal('hide');    
          setTimeout(function(){
             $.pjax.reload({container:'#pjax_folders'});  
          },1000);      
          $('.btnClose').prop('disabled', false);
    });
    $(document).on('hide.bs.modal','#file-modal', function () {
      location.reload();
    //Do stuff here
   }); 
    
</script>
<?php \richardfan\widget\JSRegister::end();?>

