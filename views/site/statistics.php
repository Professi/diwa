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
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Statistics');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="small-12 columns">
        <?= Yii::t('app', 'Searchrequests:') . ' ' . app\models\SearchRequest::find()->count(); ?>
        <br><br>
        <?= Yii::t('app', 'The most common search terms:') ?><br>
        <?php
        $dataProvider = app\models\SearchRequest::find()->select(['request', 'COUNT(*) as c'])->groupBy('request')->orderBy('c DESC')->asArray()->limit(20)->all();
        foreach ($dataProvider as $value) {
            echo $value['request'] . ' - ' . $value['c'] . ' ' . Yii::t('app', 'times') . '<br>';
        }
        ?>
        <br>


    </div>
</div>