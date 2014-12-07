<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Agents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-agent-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'agent:ntext',
            'agentHash',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
