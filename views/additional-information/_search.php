<?php

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdditionalInformationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="additional-information-search row">

    <?php $form = CustomActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'information') ?>

    <?= $form->field($model, 'source_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php CustomActiveForm::end(); ?>

</div>
