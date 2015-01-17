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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'searchRequest.request',
            ['value'=>'searchRequest.dictionary.shortname','label'=>  Yii::t('app', 'Dictionary')],
            ['attribute' => 'searchRequest.searchMethod',
                'value' => function ($data) {
                    return app\models\enums\SearchMethod::getMethodnames()[$data->getSearchRequest()->one()->searchMethod];
                }],
            ['class' => 'app\components\widgets\CustomActionColumn',
                'template' => '{view}{delete}'],
        ],
    ]);
    ?>

</div>
