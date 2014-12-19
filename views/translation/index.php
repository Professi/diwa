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
                    'modelClass' => 'Translation',
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
<?php yii\widgets\Pjax::begin();
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'dictionary.language1.shortname'],
            ['attribute' => 'word1', 'value' => 'word1.word'],
            ['attribute' => 'dictionary.language2.shortname'],
            ['attribute' => 'word2', 'value' => 'word2.word'],
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    yii\widgets\Pjax::end();
    ?>

</div>
