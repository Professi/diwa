<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shortcut */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shortcut-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shortcut')->textInput(['maxlength' => 255]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]); ?>
    <?= $form->field($model, 'kind')->dropDownList(app\models\enums\ShortcutCategory::getCategoryNames()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
