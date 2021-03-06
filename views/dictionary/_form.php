<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
$lang = \yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name');
?>
<div class="dictionary-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'language1_id')->dropDownList($lang); ?>
        <?= $form->field($model, 'language2_id')->dropDownList($lang); ?>
        <?= $form->field($model, 'active')->dropDownList($this->context->getYesOrNo()); ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>
