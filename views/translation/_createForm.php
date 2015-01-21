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
/* @var $model app\models\Translation */
/* @var $form yii\widgets\ActiveForm */
$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'language2.name', 'language1.name');
$sources = \yii\helpers\ArrayHelper::map(app\models\Source::find()->all(), 'id', 'name');
?>
<div class="translation-form row">
    <?php $form = CustomActiveForm::begin(); ?>
    <fieldset>
        <?= $form->field($model, 'dictionary_id', ['labelOptions' => ['label' => \app\models\Dictionary::getLabel()]])->dropDownList($dicts); ?>
        <?= $form->field($model, 'word1')->textInput(); ?>
        <?= $form->field($model, 'word2')->textInput(); ?>
        <?= $form->field($model, 'src_id')->dropDownList($sources); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end(); ?>
</div>