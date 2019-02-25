<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\uploads\models\Folders */

$this->title = Yii::t('app', 'Create Folders');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Folders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="folders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
