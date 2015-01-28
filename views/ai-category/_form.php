<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AiCategory */
/* @var $form app\components\widgets\CustomActiveForm */
?>

<div class="ai-category-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'importance')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
