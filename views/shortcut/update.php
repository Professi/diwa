<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shortcut */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Shortcut',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="shortcut-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>