<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => app\models\User::getLabel(),
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            ['attribute' => 'role',
                'filter' => app\models\enums\Role::getRoleNames(),
                'value' => function ($data) {
                    return \app\models\enums\Role::getRoleNames()[$data->role];
                }],
            'lastLogin',
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    ?>

</div>
