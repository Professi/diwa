<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <div class="small-12 columns small-centered">
            <div class="panel paper">
                <p><?php echo Yii::t('app', 'Please fill out the following fields to login:'); ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => $this->context->getFormClass()],
                    'errorCssClass' => $this->context->getErrorCssClass(),
                    'fieldConfig' => [
                        'template' => $this->context->getFormTemplate(),
                    ],
        ]);
        ?>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Login'); ?></legend>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?=
            $form->field($model, 'rememberMe', [
                'template' => "<div style=\"display:none\">{input}</div>\n{label}",
            ])->checkbox()
            ?>
            <?= Html::submitButton('Login', ['class' => 'small button', 'name' => 'login-button']) ?>
        </fieldset>
        <?php ActiveForm::end(); ?>
    </div>
</div>