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
?>
<section role="main" class="content-wrapper">
    <div class="row hide-on-print">
        <div class="small-12 columns small-centered">
            <?php if (Yii::$app->user->hasFlash('success')) { ?>
                <div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="dialogalert">
                    <?= Yii::$app->user->getFlash('success'); ?>
                </div>
            <?php } if (Yii::$app->user->hasFlash('failMsg')) { ?>
                <div data-alert class="alert-box alert" tabindex="0" aria-live="assertive" role="dialogalert">
                    <?= Yii::$app->user->getFlash('failMsg'); ?>            
                </div>
            <?php } ?>
        </div>
    </div>
    <?= $content; ?>
</section>
