<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PartOfSpeech */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Part Of Speech',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Part Of Speeches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="part-of-speech-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
