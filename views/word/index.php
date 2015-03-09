<?php

use yii\helpers\Html;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Words');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="word-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    app\components\widgets\CustomGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'word:ntext',
            ['attribute' => 'language_id',
                'value' => 'language.shortname',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name')],
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    ?>
    <?= CustomHtml::sidebar([app\components\CustomHtml::defaultLink('Create', app\models\Word::class, 'create')]); ?>
</div>