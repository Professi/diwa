<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AiCategory */

$this->title = Yii::t('app', 'Create {modelClass}', [
            'modelClass' => app\models\AiCategory::getLabel(),
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ai-category-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
