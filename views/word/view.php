<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Word */

$this->title = (empty($model->word) ? '' : substr($model->word, 0, 20));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="word-view row">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'word:ntext',
            ['attribute' => 'language', 'value' => $model->getLanguage()->one()->name],
            ['attribute' => 'aiWords', 'value' => $model->getAdditionalInformations(), 'format' => 'html'],
        ],
    ])
    ?>
    <?= app\components\CustomHtml::updateDeleteGroup($model->id); ?>
</div>
