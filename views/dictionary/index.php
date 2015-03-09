<?php

use yii\helpers\Html;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dictionaries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <?=
        app\components\widgets\CustomGridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'language1', 'value' => 'language1.name'],
                ['attribute' => 'language2', 'value' => 'language2.name'],
                ['attribute' => 'active', 'value' => function($data) {
                        return $this->context->getYesOrNo()[$data->active];
                    }],
                ['class' => 'app\components\widgets\CustomActionColumn'],
            ],
        ]);
        ?>
        <?= CustomHtml::sidebar([app\components\CustomHtml::defaultLink('Create', app\models\Dictionary::class, 'create'), app\components\CustomHtml::link(Yii::t('app', 'Import translation file'), 'translations')]); ?>
    </div>
</div>
