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
use app\controllers\TranslationController;
$lang1 = Yii::t('app', $dict['language1']['name']);
$lang2 = Yii::t('app', $dict['language2']['name']);
?>
<?php
yii\widgets\Pjax::begin(['id' => 'list_data']);
echo GridView::widget([
    'id' => 'gridview',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'word1.word',
            'label' => $lang1,
            'format' => 'html',
            'value' => function ($data) {
                $val = $data['word1']['word'];
                if (isset(Yii::$app->request->get()['SearchForm']['searchWord'])) {
                    return $this->context->highlightWord($val, Yii::$app->request->get()['SearchForm']['searchWord']);
                }
                return $val;
            }
        ],
        [
            'attribute' => 'word2.word',
            'label' => $lang2,
            'format' => 'html',
            'value' => function ($data) {
                $val = $data['word2']['word'];
                if (isset(Yii::$app->request->get()['SearchForm']['searchWord'])) {
                    return $this->context->highlightWord($val, Yii::$app->request->get()['SearchForm']['searchWord']);
                }
                return $val;
            }
        ],
        ['class' => 'app\components\widgets\CustomActionColumn',
            'template' => '{view}',
        ],
    ],
]);
yii\widgets\Pjax::end();
?>