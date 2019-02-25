<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\uploads\models\Folders */

$this->title = Yii::t('app', 'Update Folders: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Folders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="modal-header"><?= Html::encode($this->title);?></div>
<div class="modal-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
