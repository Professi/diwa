<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                        'modelClass' => Yii::t('app','Dictionary'),
                    ]), ['create'], ['class' => 'btn btn-success'])
            ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'language1', 'value' => 'language1.name'],
                ['attribute' => 'language2', 'value' => 'language2.name'],
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
