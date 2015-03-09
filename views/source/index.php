<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sources');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'link',
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    ?>
    <?= CustomHtml::sidebar([app\components\CustomHtml::defaultLink('Create', app\models\Source::class, 'create')]); ?>
</div>
