<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Word */
/* @var $form CustomActiveForm */
?>

<div class="word-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'language_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name')); ?>
        <?= $form->field($model, 'word', ['template' => $form->getTextAreaTemplate()])->textarea(['rows' => 6, 'placeholder' => app\models\Word::getLabel()]); ?>
        <?=
        $form->field($model, 'additionalInformations')->widget(\app\components\widgets\Selectize::className(), [
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
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
