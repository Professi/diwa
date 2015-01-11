<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Shortcut */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Shortcut',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortcut-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
