<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Translation */

$this->title = (empty($model->word1) ? '' : substr($model->word1->word, 0, 40)) . ' - ' . (empty($model->word2) ? '' : substr($model->word2->word, 0, 40));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translation-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'dictionary',
                'value' => $model->dictionary->shortname
            ],
            ['attribute' => 'word1.word', 'label' => $model->dictionary->language1->name],
            ['attribute' => 'word2.word', 'label' => $model->dictionary->language2->name],
            ['attribute' => 'source.name', 'label' => app\models\Source::getLabel(), 'value' => empty($model->source) ? '' : Html::a($model->source->name, $model->source->link), 'format' => 'html'],
            ['attribute' => 'aiTranslations', 'value' => $model->getAdditionalInformations(), 'format' => 'html'],
        ],
    ])
    ?>
    <?php
    if (Yii::$app->user->isAdvancedUser()) {
        echo app\components\CustomHtml::updateDeleteGroup($model->id);
    }
    ?>
</div>
