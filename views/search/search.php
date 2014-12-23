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
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translate');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="small-9 columns small-centered">
        <fieldset>
            <legend><?php echo $this->title; ?></legend>
            <div clasourceUrlss="search-request-index">
                <?php $form = ActiveForm::begin(); ?>
                <?php // $form->field($model, 'searchWord')->hiddenInput() ?>
                <!-- @TODO noLabel???? on selection attr is not set-->
                <?php
                echo AutoComplete::widget([
                    'model' => $model,
                    'attribute' => 'searchWord',
                    'clientOptions' => [
                        'source' => new JsExpression("
                            function( request, response ) {
                                $.ajax({
                                    url: \"" . \yii\helpers\Url::to(['word/get-words']) . "\",
                                    dataType: \"json\",
                                    data:{
                                        term: request.term,
                                        dict: $('#dict').find(':checked').val()
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                })
                            }"),
                        'autoFill' => true,
                        'minLength' => '2',
                    ],
                ]);
                ?>
                <div id="dict">
                    <?= $form->field($model, 'dictionary')->radioList($this->context->getDictionaries()); ?>
                </div>
                <?= $form->field($model, 'searchMethod')->dropDownList(\app\models\enums\SearchMethod::getMethodnames()) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-success']); ?>
                    <?= Html::button(Yii::t('app', 'Clear input'), ['id' => 'searchform-clearInput', 'class' => 'btn btn-primary']); ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </fieldset>
    </div>
</div>

<?php
$dict = app\models\Dictionary::find()->where('id=:dictId')->params([':dictId' => $model->dictionary])->one();
$lang1 = Yii::t('app', $dict->getLanguage1()->name);
$lang2 = Yii::t('app', $dict->getLanguage2()->name);
yii\widgets\Pjax::begin(['id' => 'list_data']);
echo GridView::widget([
    'id' => 'gridview',
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute' => $lang1,
            'value' => function ($data) {
                return $data->getWord1()->word;
            }],
        ['attribute' => $lang2,
            'value' => function ($data) {
                return $data->getWord2()->word;
            }],
//        ['attribute' => $lang1,
//            'value' => function ($data) {
//                return print_r($data->getWord1(),false);
//        return print_r($data,false);
//            }],
//        [
//            'attribute' => $lang2,
//            'value' => function ($data) {
//                return $data->word2;
//            }],
    ],
]);
yii\widgets\Pjax::end();
?>
<div class="row"></div>





