<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\modules\uploads\models\Folders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="folders-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
    ]); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forder')->textInput() ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <div class="form-group text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_update_folder"><?= Yii::t('app','Cancel')?></button>
        <button style="padding-left: 15px;padding-right: 15px;" type="submit" class="btn btn-primary" ><?= Yii::t('app','Save')?></button>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            if(result.action == 'create') {
                //$(\$form).trigger('reset');
                $(document).find('#modal_update_folder').modal('hide');
                setTimeout(function(){
                    $.pjax.reload({container:'#pjax_folders'});
                },1000);
            } else if(result.action == 'update') {
                $(document).find('#modal_update_folder').modal('hide');
                setTimeout(function(){
                    $.pjax.reload({container:'#pjax_folders'});
                },1000);
            }
        } else {
            <?= SDNoty::show('result.message', 'result.status')?>
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>