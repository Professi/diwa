<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UnknownWord */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Unknown Word',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unknown Words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unknown-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
