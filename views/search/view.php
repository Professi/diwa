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
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SearchRequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Search requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="search-request-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'dictionary.language1',
                'value' => $model->getDictionary()->one()->getLanguage1()->one()->shortname
            ],
            ['attribute' => 'dictionary.language2',
                'value' => $model->getDictionary()->one()->getLanguage2()->one()->shortname
            ],
            'request',
            'ipAddr',
            'userAgent.agent',
            'requestTime',
            ['attribute' => 'searchMethod',
                'value' => app\models\enums\SearchMethod::getMethodnames()[$model->searchMethod]
            ],
        ],
    ])
    ?>
</div>
