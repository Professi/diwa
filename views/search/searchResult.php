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

use yii\grid\GridView;

$lang1 = Yii::t('app', $dict['language1']['name']);
$lang2 = Yii::t('app', $dict['language2']['name']);
yii\widgets\Pjax::begin(['id' => 'list_data']);
echo GridView::widget([
    'id' => 'gridview',
    'dataProvider' => $dataProvider,
    'columns' => [
        ['attribute' => $lang1,
            'value' => function ($data) {
                if (Yii::$app->params['cacheTranslatedWords']) {
                    return $data['word1']['word'];
                }
                return app\models\Word::findOne($data['word1_id'])->word;
            }],
        ['attribute' => $lang2,
            'value' => function ($data) {
                if (Yii::$app->params['cacheTranslatedWords']) {
                    return $data['word2']['word'];
                }
                return app\models\Word::findOne($data['word2_id'])->word;
            }],
    ],
]);
yii\widgets\Pjax::end();
?>