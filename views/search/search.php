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
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translate');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="small-9 columns small-centered">
        <fieldset>
            <legend><?php echo $this->title; ?></legend>
            <div class="search-request-index">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'searchWord')->textInput() ?>

                <?= $form->field($model, 'dictionary')->radioList($this->context->getDictionaries()); ?>

                <?= $form->field($model, 'searchMethod')->dropDownList(\app\models\enums\SearchMethod::getMethodnames()) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-success']); ?>
                    <?= Html::submitButton(Yii::t('app', 'Clear input'), ['class' => 'btn btn-primary']); ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </fieldset>
    </div>
</div>

<?php
if ($dataProvider != null) {
    yii\widgets\Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['attribute' => 'word1',
                'value' => function ($data) {
                    return $data['w1'];
                }],
            ['attribute' => 'word2',
                'value' => function ($data) {
                    return $data['w2'];
                }],
        ],
    ]);
    yii\widgets\Pjax::end();
}
?>





