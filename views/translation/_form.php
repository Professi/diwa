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
        <?=
        $form->field($model, 'word1', ['labelOptions' => ['label' => Yii::t('app', 'Word') . ' 1']])->widget(AutoComplete::className(), [
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
        ?>
        <?=
        $form->field($model, 'word2', ['labelOptions' => ['label' => Yii::t('app', 'Word') . ' 2']])->widget(AutoComplete::className(), [
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
        ?>
        <?php 
//        echo  $form->field($model, 'additionalInformations')->widget(vova07\select2\Widget::className(), [
//            'options' => [
////                'multiple' => true,
//                'placeholder' => Yii::t('app', 'Enter any id of a information or enter text to search for informations'),
////                'width' => '100%',
//            ],
//            'settings' => [
//                'ajax' => [
//                'url' => \yii\helpers\Url::to(['additional-information/get-informations']),
//                'dataType' => 'json',
//                'data' => new JsExpression('function (params) {'
//                        . 'return {'
//                        . 'q: params.term,'
//                        . 'page: params.page'
//                        . '};'
//                        . '}'),
////                'processResults' => new \yii\web\JsExpression('function (data,page) {'
////                        . 'return {'
////                        . 'results: data.items'
////                        . '};'
////                        . '}'),
//                    ],
//                'cache' => true,
//                'minimumInputLength' => 1,
//            ]
//        ]);
        ?>
        <br>

        <?= $form->field($model, 'src_id')->dropDownList($sources); ?>
        <div class="form-group">
            <?= Html::submitButton($model->create ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->create ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
