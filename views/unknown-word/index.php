<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Unknown words');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unknown-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'request',
                'value' => 'searchRequest.request',
                'label' => app\models\SearchRequest::getLabel()],
            [
                'attribute' => 'dictionary',
                'value' => 'searchRequest.dictionary.shortname',
                'filter' => \app\models\Dictionary::getFilter(),
                'label' => \app\models\Dictionary::getLabel(),
            ],
            ['attribute' => 'searchMethod',
                'filter' => app\models\enums\SearchMethod::getMethodnames(),
                'value' => function ($data) {
                    return app\models\enums\SearchMethod::getMethodnames()[$data->searchRequest->searchMethod];
                }],
            ['class' => 'app\components\widgets\CustomActionColumn',
                'template' => '{view}{delete}'],
        ],
    ]);
    ?>

</div>
