<?php

/* Copyright (C) 2014  Christian Ehringfeld, David Mock
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
        <div class="footer row hide-for-print">
            <hr>
            <div class="small-6 large-4 columns">
                <p>
                    <?php echo Yii::t('app', 'Copyright'); ?> &copy; <?php
                    echo date('Y') . ' ';
                    echo ('Christian Ehringfeld');
                    ?>
                </p>
            </div>
            <div class="large-4 columns hide-for-small js_hide"></div>
            <div class="large-4 columns hide-for-small js_show">
                <p>
                    <?php echo Yii::t('app', 'Press <kbd>Esc</kbd> to toggle the navigation menu.'); ?> 
                </p>
            </div>
            <div class="small-6 large-4 columns">
                <?php
                echo \yii\widgets\Menu::widget([
                    'options' => ['class' => 'right inline-list'],
                    'items' => [
                        ['label' => Yii::t('app', 'FAQ'), 'url' => ['/site/help']],
                        ['label' => Yii::t('app', 'Imprint'), 'url' => ['/site/imprint']],
                        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                        ['label' => Yii::t('app', 'Statistics'), 'url' => ['/site/statistics'], 'visible' => Yii::$app->user->isAdmin() || Yii::$app->user->isTerminologist()]
                    ],
                ]);
                ?>
            </div>
        </div> 
        <div class="infobox" style="display: none;"><p></p></div>