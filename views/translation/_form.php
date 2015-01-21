<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Translation */
/* @var $form yii\widgets\ActiveForm */
$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'shortname');
$sources = \yii\helpers\ArrayHelper::map(app\models\Source::find()->all(), 'id', 'name');
$create = $model instanceof \app\models\forms\TranslationForm;
?>
<div class="translation-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'dictionary_id', ['labelOptions' => ['label' => \app\models\Dictionary::getLabel()]])->dropDownList($dicts); ?>
        <?php if ($create) { ?>
            <?= $form->field($model, 'word1')->textInput(); ?>
            <?= $form->field($model, 'word2')->textInput(); ?>
        <?php } else { ?>
            <?= $form->field($model->word1, 'word')->textInput(['name' => 'Word1[word]']); ?>
            <?= $form->field($model->word2, 'word')->textInput(['name' => 'Word2[word]']); ?>
        <?php } ?>
        <?= $form->field($model, 'src_id')->dropDownList($sources); ?>
        <div class="form-group">
            <?= Html::submitButton($create ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $create ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
