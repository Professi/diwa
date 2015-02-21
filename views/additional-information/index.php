<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdditionalInformationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Additional informations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-information-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => app\models\AdditionalInformation::getLabel(),
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
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
</div>
