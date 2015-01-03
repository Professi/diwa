<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Translation */
/* @var $form yii\widgets\ActiveForm */
$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'language2.name', 'language1.name');
?>

<div class="translation-form">

    <?php $form = $this->context->getAssetTemplate()->getDefaultActiveForm(); ?>

    <?= $form->field($model, 'dictionary_id')->dropDownList($dicts); ?>

    <?= $form->field($model->word1, 'word')->textInput(['name'=>'Word1[word]']); ?>

    <?= $form->field($model->word2, 'word')->textInput(['name'=>'Word2[word]']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
