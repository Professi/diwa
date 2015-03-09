<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdditionalInformationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \app\models\AdditionalInformation::getLabel(true);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-information-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'category_id', 'value' => 'category.name', 'label' => app\models\AiCategory::getLabel(), 'filter' => \app\models\AiCategory::getFilter()],
            'information:ntext',
            ['attribute' => 'source_id', 'value' => 'source.name', 'label' => app\models\Source::getLabel(), 'filter' => \app\models\Source::getFilter()],
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    ?>
    <?= CustomHtml::sidebar([app\components\CustomHtml::defaultLink('Create', \app\models\AdditionalInformation::class, 'create')]); ?>
</div>
