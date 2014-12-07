<?php

use yii\helpers\Html;
use yii\widgets\ListView;

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
                        'modelClass' => 'Dictionary',
                    ]), ['create'], ['class' => 'btn btn-success'])
            ?>
        </p>
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
    },
        ])
        ?>
    </div>
</div>
