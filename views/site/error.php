<?php
/* * Copyright (C) 2014  Christian Ehringfeld
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
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
$this->title = $name;
?>
<div class="push"></div>
<div class="push"></div>
<div class="row">
    <div class="small-8 columns small-centered">
        <div class="panel">
            <div class="row">
                <div class="small-2 columns text-center">
                    <i class="fi-alert callout-icon"></i>
                </div>
                <div class="small-10 columns">
                    <h2><?= $name; ?></h2>   
                    <?= nl2br(Html::encode($message)) ?>
                </div>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a('<b>' . Yii::t('app', 'Back to home') . '</b>', ['site/index']); ?>
        </p>
    </div>
</div>

