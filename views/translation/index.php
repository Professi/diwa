<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Dictionary;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translation-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => app\models\Translation::getLabel(),
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
    <?php
    $attributeLabels = $filterModel->attributeLabels();
    $langs = \yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name');
    yii\widgets\Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'language1', 'filter' => $langs, 'value' => 'dictionary.language1.shortname', 'label' => $attributeLabels['language1']],
            ['attribute' => 'word1Term', 'value' => 'word1.word', 'label' => $attributeLabels['word1']],
            ['attribute' => 'language2', 'filter' => $langs, 'value' => 'dictionary.language2.shortname', 'label' => $attributeLabels['language2']],
            ['attribute' => 'word2Term', 'label' => $attributeLabels['word2']],
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    yii\widgets\Pjax::end();
    ?>

</div>
