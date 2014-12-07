<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Unknown Words');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unknown-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'dictionary_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
