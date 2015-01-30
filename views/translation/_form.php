<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Translation */
/* @var $form yii\widgets\ActiveForm */
$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'shortname');
$sources = \yii\helpers\ArrayHelper::map(app\models\Source::find()->all(), 'id', 'name');
$create = $model instanceof \app\models\forms\TranslationForm;
$dictRequest = $create ? 'translationform' : 'translation';
?>
<div class="translation-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'dictionary_id', ['labelOptions' => ['label' => \app\models\Dictionary::getLabel()]])->dropDownList($dicts); ?>
        <?= $form->field($model, $create ? 'word1' : 'word', ['template' => $form->getLabelTemplate()]); ?>
        <?=
        AutoComplete::widget([
            'model' => $model,
            'value' => $create ? '' : $model->word1->word,
            'attribute' => $create ? 'word1' : null,
            'name' => 'Word1[word]',
            'clientOptions' => [
                'source' => new JsExpression("
                            function( request, response ) {
                                $.ajax({
                                    url: \"" . \yii\helpers\Url::to(['word/get-words']) . "\",
                                    dataType: \"json\",
                                    data:{
                                        term: request.term,
                                        dict: $('#" . $dictRequest . "-dictionary_id').val(),
                                        regex: 0,
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                })
                            }"),
                'autoFill' => true,
                'minLength' => '2',
            ],
        ]);
        ?>

        <?= $form->field($model, $create ? 'word2' : 'word', ['template' => $form->getLabelTemplate()]); ?>
        <?=
        AutoComplete::widget([
            'model' => $model,
            'value' => $create ? '' : $model->word2->word,
            'name' => 'Word2[word]',
            'attribute' => $create ? 'word2' : null,
            'clientOptions' => [
                'source' => new JsExpression("
                            function( request, response ) {
                                $.ajax({
                                    url: \"" . \yii\helpers\Url::to(['word/get-words']) . "\",
                                    dataType: \"json\",
                                    data:{
                                        term: request.term,
                                        dict: $('#" . $dictRequest . "-dictionary_id').val(),
                                        regex: 0,
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                })
                            }"),
                'autoFill' => true,
                'minLength' => '2',
            ],
        ]);
        ?>

        <?= $form->field($model, 'src_id')->dropDownList($sources); ?>
        <div class="form-group">
            <?= Html::submitButton($create ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $create ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
