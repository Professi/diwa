<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdditionalInformation */
/* @var $form app\components\widgets\CustomActiveForm */
?>

<div class="additional-information-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'category_id')->textInput() ?>
        <?= $form->field($model, 'information')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'source_id')->textInput() ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
