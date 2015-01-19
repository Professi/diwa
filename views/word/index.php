<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Words');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="word-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => Yii::t('app', 'Word'),
                ]), ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>
    <?=
    app\components\widgets\CustomGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'word:ntext',
            ['attribute' => 'language_id',
                'value' => 'language.shortname',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name')],
            ['class' => 'app\components\widgets\CustomActionColumn'],
        ],
    ]);
    ?>

</div>


<div class="form-group field-translationuploadform-file required">
    <div class="row collapse">
        <div class="small-4 columns">
            <span class="prefix">
                <label class="control-label" for="translationuploadform-file">Datei</label>
            </span>
        </div>
        <div class="small-4 columns">
            <div class="prefix button file-input">
                <i class="fi-upload"/>
                <span>&nbsp;Choose file</span>
                <input type="hidden" name="TranslationUploadForm[file]" value="">
                <input type="file" id="translationuploadform-file" name="TranslationUploadForm[file]" value="">
            </div>
        </div>
    </div>
</div> 

<div class="row collapse">
    <div class="small-4 columns">
        <span class="prefix">
            <label for="CsvUpload_file">CSV Datei hochladen</label>
        </span>
    </div>
    <div class="small-4 columns">
        <div class="prefix button file-input">
            <i class="fi-upload"></i>
            <span>&nbsp;Datei auswählen</span>
            <input id="ytCsvUpload_file" type="hidden" value="" name="CsvUpload[file]" />
            <input name="CsvUpload[file]" id="CsvUpload_file" type="file" />
            <div class="error" id="CsvUpload_file_em_" style="display:none">
            </div>
        </div>
    </div>
    <div class="small-4 columns">
        <input type="text" value="" name="" id="file-input-name" readonly="readonly">
    </div>
</div>