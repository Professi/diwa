<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdditionalInformation */

$this->title = substr($model->information, 0, 20);
$this->params['breadcrumbs'][] = ['label' => \app\models\AdditionalInformation::getLabel(true), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-information-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category.name',
            'information:ntext',
            'source.name',
        ],
    ])
    ?>
    <?= app\components\CustomHtml::updateDeleteGroup($model->id); ?>
</div>
