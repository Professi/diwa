<?php
/* Copyright (C) 2015  Christian Ehringfeld
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
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use app\components\CustomHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Translate');
$this->params['breadcrumbs'][] = $this->title;
$lang = \yii\helpers\ArrayHelper::map(\app\models\Language::find()->all(), 'id', 'name');
?>
<div class="row">
    <div class="small-9 columns small-centered">
        <fieldset>
            <legend><?= $this->title; ?></legend>
            <div class="search-request-index">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'search-form',
                            'method' => 'get',
                            'action' => ['translation/single-search'],
                ]);
                echo $form->field($model, 'searchWord')->widget(AutoComplete::class, [
                    'clientOptions' => [
                        'source' => new JsExpression("
                            function( request, response ) {
                                $.ajax({
                                    url: \"" . \yii\helpers\Url::to(['word/get-words-by-language']) . "\",
                                    dataType: \"json\",
                                    data:{
                                        term: request.term,
                                        lang: $('#srcLangField').find(':checked').val(),
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
                    <?= Html::error($model, 'dictionary'); ?>
                </div>
                <div id="srcLangField">
                    <?= $form->field($model, 'srcLang')->dropDownList($lang); ?>
                </div>
                <?= $form->field($model, 'targetLang')->dropDownList($lang); ?>
                <?= $form->field($model, 'searchMethod')->dropDownList(\app\models\enums\SearchMethod::getMethodnames()); ?>
                <div class="<?= CustomHtml::$groupClass ?>">
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => CustomHtml::$buttonClass]); ?>
                    <?= Html::button(Yii::t('app', 'Clear input'), ['id' => 'searchform-clearInput', 'class' => CustomHtml::$buttonClass]); ?>
                    <?= Html::a(Yii::t('app', 'Default search'), ['search'], ['class' => CustomHtml::$buttonClass]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </fieldset>
    </div>
</div>
<?= $partial; ?>