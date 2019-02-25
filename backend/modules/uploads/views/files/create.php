<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\uploads\models\Files */

$this->title = Yii::t('app', 'Create Files');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal-header">
    <?= $this->title; ?>
</div>
<div class="modal-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
