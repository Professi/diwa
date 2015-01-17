<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shortcuts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortcut-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => \app\models\Shortcut::getLabel(),
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'shortcut',
            'name',
            ['attribute' => 'kind',
                'filter' => app\models\enums\ShortcutCategory::getCategoryNames(),
                'value' => function ($data) {
                    return is_numeric($data->kind) ? app\models\enums\ShortcutCategory::getCategoryNames()[$data->kind] : '';
                }],
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    ?>

</div>
