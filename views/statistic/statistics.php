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

use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?= $this->title; ?></h1>
    <div class="small-12 columns">
        <div>
            <?= Yii::t('app', 'Search requests') . ': ' . $totalRequests ?>
        </div>
        <div>
            <h3><?= Yii::t('app', 'Words'); ?></h3>
            <?php
            $langs = app\models\Language::find()->all();
            foreach ($langs as $lang) {
                echo $lang->name . ': ' . app\models\Word::find()->where(['language_id' => $lang->getId()])->count() . '<br>';
            }
            ?>
        </div>        
        <div>
            <h3><?= Yii::t('app', 'Translations'); ?></h3>
            <?php
            $dicts = app\models\Dictionary::find()->all();
            foreach ($dicts as $dict) {
                echo $dict->getLongname() . ': ' . app\models\Translation::find()->where(['dictionary_id' => $dict->getId()])->count() . '<br>';
            }
            ?>
        </div>
        <div>
            <h3><?= Yii::t('app', 'The most common search terms') . ':' ?></h3>
            <?php
            foreach ($mostCommon as $value) {
                echo $value['request'] . ' - ' . $value['c'] . ' ' . Yii::t('app', 'times') . '<br>';
            }
            ?>
            <br>
            <?=
            Highcharts::widget([
                'options' => [
                    'title' => ['text' => Yii::t('app', 'Search requests per month')],
                    'xAxis' => [
                        'categories' => $monthLabels
                    ],
                    'yAxis' => [
                        'title' => ['text' => Yii::t('app', 'Requests')],
                        'min' => 0,
                    ],
                    'series' => $series,
                ]
            ]);
            ?>
        </div>
    </div>
</div>