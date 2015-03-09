<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'role')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
