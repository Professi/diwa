<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-index">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
    },
        ])
        ?>
    </div>
    <br>
    <?= CustomHtml::sidebar([app\components\CustomHtml::defaultLink('Create', app\models\Language::class, 'create')]); ?>
</div>
