<?php

use yii\helpers\Html;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    app\components\widgets\CustomGridView::widget([
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
    <?= CustomHtml::sidebar([app\components\CustomHtml::defaultLink('Create', app\models\User::class, 'create')]); ?>
</div>
