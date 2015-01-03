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
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <div class="row">
        <div class="small-12 columns small-centered">
            <?php if (Yii::$app->user->hasFlash('contactFormSubmitted')): ?>
                <div class="flash-success">
                    <?php echo Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'); ?>
                </div>
            <?php else: ?>
                <div class="panel paper">
                    <p><?php echo Yii::t('app', 'If you have questions, please fill out the following form to contact us. Thank you.'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <?php $form = $this->context->getAssetTemplate()->getDefaultActiveForm(); ?>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Contact'); ?></legend>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'subject') ?>
            <?=
            $form->field($model, 'body')->textArea(['rows' => 6, 'cols' => 50, 'placeholder' => Yii::t('app', 'Your message'),
                'template' => '{input}',
                    ]
            );
            ?>
            <?=
            $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>'
            ]);
            ?>
            <?= Html::submitButton('Submit', ['class' => 'small button', 'name' => 'contact-button']) ?>
        </fieldset>
        <?php ActiveForm::end(); ?>
    </div>
</div>