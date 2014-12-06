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
$this->title = Yii::t('app', 'Imprint');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="small-12 columns">
        <h2 class='subheader'><?php echo Html::encode(Yii::t('app', 'Imprint')); ?></h2>
        <hr>
        <p> <?php echo Yii::$app->params['imprintName']; ?><br>
            <?php echo Yii::$app->params['imprintStreet']; ?><br>
            <?php echo Yii::$app->params['imprintPlace']; ?><br>
            <?php echo Yii::t('app', 'Email') . ':'; ?> <a href="mailto:<?php echo Yii::$app->params['imprintEmail']; ?>"><?php echo Yii::$app->params['imprintEmail']; ?></a>
        </p>
        <p><?php echo Yii::t('app', 'This application is licensed with the GNU General Public License Version 3') . '(&nbsp;&nbsp;<a href="http://www.gnu.de/documents/gpl-3.0.en.html" ><i class="fi-page-export"></i>&nbsp;' . Yii::t('app', 'Link') . '</a> ).'; ?>
            <br><?php echo Yii::t('app', 'The authors are: {ppl1} and {ppl2}(Design).', ['ppl1' => 'Christian Ehringfeld', 'ppl2' => 'David Mock']); ?></p>
        <p><?php echo Yii::t('app', 'Website'); ?>&nbsp;&nbsp;<a href="http://www.synlos.net/"><i class="fi-page-export"></i>&nbsp;Link</a></p>
        <p><?php echo Yii::t('app', 'This site has been created with the following tools and ressources:'); ?><br>
            PHP&nbsp;&nbsp;<a href="http://www.php.net"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Yii2 Framework&nbsp;&nbsp;<a href="http://www.yiiframework.com" ><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            ZURB Foundation Framework&nbsp;&nbsp;<a href="http://foundation.zurb.com"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            IcoMoon Icon Fonts&nbsp;&nbsp;<a href="http://icomoon.io"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Google Web Fonts&nbsp;&nbsp;<a href="http://www.google.com/webfonts"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
            Subtle Patterns&nbsp;&nbsp;<a href="http://www.subtlepatterns.com"><i class="fi-page-export"></i>&nbsp;<?php echo Yii::t('app', 'Link'); ?></a><br>
        </p>
        <p class="text-center"><?php echo Html::a('<b>' . Yii::t('app', 'Back to home') . '</b>', ['site/index']); ?> </p>
    </div>
</div>