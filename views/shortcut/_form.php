<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shortcut */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="shortcut-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'shortcut')->textInput(); ?>
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'kind')->dropDownList(app\models\enums\ShortcutCategory::getCategoryNames()); ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
