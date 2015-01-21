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

use app\components\widgets\CustomActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Upload translation file');
$dicts = \yii\helpers\ArrayHelper::map(\app\models\Dictionary::find()->all(), 'id', 'language2.name', 'language1.name');
$sources = \yii\helpers\ArrayHelper::map(app\models\Source::find()->all(), 'id', 'name');
?>
<div class="row">
    <p class="panel">
        <?php echo Yii::t('app', 'If you upload something, grab a coffee and lean back. This could take a while.'); ?>
    </p>
    <?php $form = CustomActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <fieldset>
        <?= $form->field($model, 'dictionary')->dropDownList($dicts) ?>
        <?= $form->field($model, 'delimiters')->textInput() ?>
        <?= $form->field($model, 'file', ['template' => $form->getFileInputTemplate()])->fileInput() ?>
        <?= $form->field($model, 'source')->dropDownList($sources) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-success']) ?>
        </div>
    </fieldset>
    <?php CustomActiveForm::end() ?>
</div>