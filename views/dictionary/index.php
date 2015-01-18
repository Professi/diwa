<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dictionaries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?=
            Html::a(Yii::t('app', 'Create {modelClass}', [
                        'modelClass' => \app\models\Dictionary::getLabel(),
                    ]), ['create'], ['class' => 'btn btn-success'])
            ?>
        </p>
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
        <p>
            <?=
            Html::a(Yii::t('app', 'Import translation file', [
                    ]), ['translations'], ['class' => 'btn btn-success'])
            ?>
        </p>

    </div>
</div>
