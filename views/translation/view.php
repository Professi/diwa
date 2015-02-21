<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Translation */

$this->title = (empty($model->word1) ? '' : substr($model->word1->word, 0, 15)) . ' - ' . (empty($model->word2) ? '' : substr($model->word2->word, 0, 15));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translation-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'dictionary',
                'value' => $model->dictionary->shortname
            ],
            ['attribute' => 'word1.word', 'label' => $model->dictionary->language1->name],
            ['attribute' => 'word2.word', 'label' => $model->dictionary->language2->name],
            ['attribute' => 'source.name', 'label' => app\models\Source::getLabel()],
            ['attribute' => 'aiTranslations', 'value' => $model->getAdditionalInformations(), 'format' => 'html'],
        ],
    ])
    ?>

</div>
