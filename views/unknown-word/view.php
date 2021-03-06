<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UnknownWord */

$this->title = $model->getSearchRequest()->one()->request;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unknown words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unknown-word-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'searchRequest.dictionary', 'value' => $model->searchRequest->dictionary->getLongname()],
            'searchRequest.request',
            ['attribute' => 'searchRequest.searchMethod',
                'value' => app\models\enums\SearchMethod::getMethodnames()[$model->searchRequest->searchMethod],
            ],
        ],
    ])
    ?>
    <?= app\components\CustomHtml::updateDeleteGroup($model->id); ?>
</div>
