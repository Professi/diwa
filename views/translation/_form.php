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
?>
<div class="translation-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'dictionary_id', ['labelOptions' => ['label' => \app\models\Dictionary::getLabel()]])->dropDownList($dicts); ?>
        <?= $form->field($model, 'word1', ['labelOptions' => ['label' => Yii::t('app', 'Word') . ' 1']])->widget(AutoComplete::className(), [
            'name' => 'Word1[word]',
            'clientOptions' => [
                'source' => new JsExpression("
                            function( request, response ) {
                                $.ajax({
                                    url: \"" . \yii\helpers\Url::to(['word/get-words']) . "\",
                                    dataType: \"json\",
                                    data:{
                                        term: request.term,
                                        dict: $('#translationform-dictionary_id').val(),
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
        echo $form->field($model, 'word2', ['labelOptions' => ['label' => Yii::t('app', 'Word') . ' 2']])->widget(AutoComplete::className(), [
            'name' => 'Word2[word]',
            'clientOptions' => [
                'source' => new JsExpression("
                            function( request, response ) {
                                $.ajax({
                                    url: \"" . \yii\helpers\Url::to(['word/get-words']) . "\",
                                    dataType: \"json\",
                                    data:{
                                        term: request.term,
                                        dict: $('#translationform-dictionary_id').val(),
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
        echo $form->field($model, 'additionalInformations')->widget(\app\components\widgets\Selectize::className(), [
            'clientOptions' => [
                'placeholder' => \app\controllers\AdditionalInformationController::getPlaceholder(),
                'dataAttr' => 'value',
                'delimiter' => \app\controllers\AdditionalInformationController::DELIMITER,
                'valueField' => 'id',
                'labelField' => 'text',
                'plugins' => ['remove_button'],
                'create' => false,
                'load' => new JsExpression(
                        'function(query, callback) {
                            if (!query.length) return callback();
        $.ajax({
            url: "' . \yii\helpers\Url::to(['additional-information/get-informations']) . '",
            type: "GET",
            dataType: "json",
            data: {
                q: query,
                page_limit: 10,
            },
                        error: function() {
                callback();
            },
            success: function(res) {
                callback(res);
            }
        });
    }'
                ),
            ],
        ]);
        echo $form->field($model, 'src_id')->dropDownList($sources);
        ?>
        <div class="<?= \app\components\CustomHtml::$groupClass ?>">
            <?= Html::submitButton(!$model->translation ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => !$model->translation ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
