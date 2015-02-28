<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Dictionary */

$this->title = $model->language1->name . ' - ' . $model->language2->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dictionaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-view row">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'language1',
                'value' => $model->getLanguage1()->one()->name,
            ],
            [
                'attribute' => 'language2',
                'value' => $model->getLanguage2()->one()->name,
            ],
        ],
    ])
    ?>
    <?= app\components\CustomHtml::updateDeleteGroup($model->id); ?>
</div>
