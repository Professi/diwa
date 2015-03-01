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
?>
<h1 class="text-center hide show-for-print" style="font-family: 'ClickerScript-Regular';"><?= Yii::t('app', 'DiWA'); ?></h1>
<nav class="top-bar hide-on-print" data-topbar data-options="is_hover: false">
    <ul class="title-area">
        <li class="name">
            <h2> 
                <?= Html::a(Yii::t('app', 'DiWA'), ['/site/index']); ?>
            </h2>
        </li>
        <li class="toggle-topbar menu-icon"><a href=""><span><?= Yii::t('app', 'Menu'); ?></span></a></li>
    </ul>
    <section class="top-bar-section">
        <ul class="right">
            <li>
                <a href="http://<?= Yii::$app->params['websiteLink']; ?>" target="_blank">
                    <img id="logo" 
                         src="<?= $asset->baseUrl; ?>/img/dictionary.gif"
                         alt="<?= Yii::$app->params['altWebsiteLink'] ?>">
                         <?= Yii::t('app', 'DiWA'); ?>
                </a>
            </li>
            <li class="toggle-topbar menu-icon"><a href=""><span><?= Yii::t('app', 'Menu'); ?></span></a></li>
        </ul>
        <ul class="left show-for-small-only">
            <?
            if (!Yii::$app->user->isGuest) {
                echo $this->context->getMenu()->generate(true);
            }
            ?>
            <li>
                <a onClick="event.preventDefault();
                        window.print();" href="#">
                    <i class="fi-print"></i><?= Yii::t('app', 'Print'); ?>
                </a>
            </li>
        </ul>
    </section>
</nav>
<div class="sticky sticky-nav hide-for-small hide-on-print">
    <ul class="medium-block-grid-6 large-block-grid-8 text-center ul-nav" data-topbar>
        <?= $this->context->getMenu()->generate(false); ?>
        <li>
            <a onClick="event.preventDefault();
                    window.print();" href="#">
                <i class="fi-print"></i><span><?= Yii::t('app', 'Print'); ?></span>
            </a>
        </li>
        <li class="no-highlight">
            <div id="language-selector">
                <i class="fi-comment-quotes"></i>
                <?=
                \yii\widgets\Menu::widget([
                    'options' => ['class' => 'right inline-list'],
                    'items' => Yii::$app->lang->getMenuItems(),
                ]);
                ?>
            </div>
        </li>
    </ul>
</div>
