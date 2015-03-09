<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Agents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-agent-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    app\components\widgets\CustomGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'agent:ntext',
            'agentHash',
            ['class' => 'app\components\widgets\CustomActionColumn',
                'template' => '{view}'],
        ],
    ]);
    ?>

</div>
