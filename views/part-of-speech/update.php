<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PartOfSpeech */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Part Of Speech',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Part Of Speeches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="part-of-speech-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
