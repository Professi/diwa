<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
$lang = \yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name');
?>

<div class="dictionary-form">
    <?php $form = $this->context->getAssetTemplate()->getDefaultActiveForm(); ?>

    <?= $form->field($model, 'language1_id')->dropDownList($lang) ?>

    <?= $form->field($model, 'language2_id')->dropDownList($lang) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
