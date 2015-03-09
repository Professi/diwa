<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdditionalInformation */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => app\models\AdditionalInformation::getLabel(),
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => \app\models\AdditionalInformation::getLabel(true), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="additional-information-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
