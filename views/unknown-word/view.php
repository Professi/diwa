<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UnknownWord */

$this->title = $model->getSearchRequest()->one()->request;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unknown Words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unknown-word-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'id',
            ['attribute' => 'searchRequest.dictionary.language1',
                'value' => $model->getSearchRequest()->one()->getDictionary()->one()->getLanguage1()->one()->name,
            ],
            ['attribute' => 'searchRequest.dictionary.language2',
                'value' => $model->getSearchRequest()->one()->getDictionary()->one()->getLanguage2()->one()->name,
            ],
            'searchRequest.request',
            ['attribute' => 'searchRequest.searchMethod',
                'value' => app\models\enums\SearchMethod::getMethodnames()[$model->getSearchRequest()->one()->searchMethod],
            ],
        ],
    ])
    ?>

</div>
