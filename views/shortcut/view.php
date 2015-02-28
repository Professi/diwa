<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shortcut */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shortcuts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortcut-view row">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'shortcut',
            'name',
            ['attribute' => 'kind', 'value' => is_numeric($model->kind) ? app\models\enums\ShortcutCategory::getCategoryNames()[$model->kind] : ''
            ],
]])
    ?>
    <?= app\components\CustomHtml::updateDeleteGroup($model->id); ?>
</div>
