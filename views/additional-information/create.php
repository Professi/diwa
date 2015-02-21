<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdditionalInformation */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => app\models\AdditionalInformation::getLabel(),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Additional informations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-information-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
