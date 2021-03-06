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
            <?= Yii::t('app', 'Copyright'); ?> &copy; 
            <?= date('Y') . ' ' . ('Christian Ehringfeld'); ?>
        </p>
    </div>
    <div class="large-4 columns hide-for-small js_hide"></div>
    <div class="large-4 columns hide-for-small js_show">
        <p>
            <?= Yii::t('app', 'Press <kbd>Esc</kbd> to toggle the navigation menu.'); ?> 
        </p>
    </div>
    <div class="small-6 large-4 columns">
        <?=
        \yii\widgets\Menu::widget([
            'options' => ['class' => 'right inline-list'],
            'items' => $this->context->getAssetTemplate()->getFooterMenu(),
        ]);
        ?>
    </div>
</div> 
<div class="infobox" style="display: none;"><p></p></div>