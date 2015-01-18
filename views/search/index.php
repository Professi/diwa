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

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search requests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="search-request-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    app\components\widgets\CustomGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'dictionary_id',
                'value' => 'dictionary.shortname',
                'filter' => \app\models\Dictionary::getFilter(),
                'label' => \app\models\Dictionary::getLabel(),
            ],
            'request',
            ['attribute' => 'searchMethod',
                'filter' => app\models\enums\SearchMethod::getMethodnames(),
                'value' => function ($data) {
                    return app\models\enums\SearchMethod::getMethodnames()[$data->searchMethod];
                }],
            ['attribute' => 'requestTime'],
            ['class' => 'app\components\widgets\CustomActionColumn',
                'template' => '{view}',
            ],
        ],
    ]);
    ?>

</div>
