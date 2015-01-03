<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Word */
/* @var $form yii\widgets\ActiveForm */


//$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'language2.name', 'language1.name');
?>

<div class="word-form">
    <?php $form = $this->context->getAssetTemplate()->getDefaultActiveForm(); ?>
    <?= $form->field($model, 'language_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(),'id','name')); ?>
    <?= $form->field($model, 'word')->textarea(['rows' => 6]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
