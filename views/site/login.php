<?php
/* Copyright (C) 2014  Christian Ehringfeld
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use yii\helpers\Html;
use app\components\widgets\CustomActiveForm;

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
                <p><?= Yii::t('app', 'Please fill out the following fields to login:'); ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $form = CustomActiveForm::begin(); ?>
        <fieldset>
            <legend><?= Yii::t('app', 'Login'); ?></legend>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?=
            $form->field($model, 'rememberMe', [
                'template' => "<div style=\"display:none\">{input}</div>\n{label}",
            ])->checkbox();
            ?>
            <?= Html::submitButton('Login', ['class' => \app\components\CustomHtml::$buttonClass, 'name' => 'login-button']) ?>
        </fieldset>
        <?php CustomActiveForm::end(); ?>
    </div>
</div>