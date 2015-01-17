<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-index">
    <div class="row">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?=
            Html::a(Yii::t('app', 'Create {modelClass}', [
                        'modelClass' => \app\models\Language::getLabel(),
                    ]), ['create'], ['class' => 'btn btn-success'])
            ?>
        </p>
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
</div>
