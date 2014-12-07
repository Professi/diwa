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

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'language2.name', 'language1.name');
?>

<div class="row">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'dictionary')->dropDownList($dicts) ?>
    <?= $form->field($model, 'delimiters')->textInput() ?>
    <?= $form->field($model, 'file')->fileInput() ?>

        <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>