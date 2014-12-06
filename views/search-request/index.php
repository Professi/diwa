<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search Requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="search-request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Search Request',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dictionary_id',
            'request',
            'ipAddr',
            'useragent_id',
            // 'requestTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
