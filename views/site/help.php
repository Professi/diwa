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
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'DiWA';
$categories = app\models\enums\ShortcutCategory::getCategoryNames();
?>
<div class="site-contact">
    <div class="row">
        <h1 class='subheader'><?= Html::encode(Yii::t('app', 'Help')); ?></h1>
        <h2><?= Yii::t('app', 'Search methods'); ?></h2>
        <? foreach (app\models\enums\SearchMethod::getMethodnames() as $key => $value) { ?>
            <h3><?= Html::encode($value) ?></h3>
            <p><?= app\models\enums\SearchMethod::getDescription($key) ?></p>
        <? }
        ?>
            <br>
        <?php foreach ($categories as $key => $value) {
            ?><h3><?= $value; ?></h3>
            <table class="table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            <?= Yii::t('app', 'Shortcut'); ?>
                        </th>
                        <th>
                            <?= Yii::t('app', 'Name'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $shortcuts = \app\models\Shortcut::find()->where(['kind' => $key])->orderBy('shortcut')->all();
                    foreach ($shortcuts as $s) {
                        ?>
                        <tr>
                            <?php
                            echo '<td>' . Html::encode($s->shortcut) . '</td>';
                            echo '<td>' . Html::encode(Yii::t('app', $s->name)) . '</td>';
                            ?>
                        </tr>  
                    <?php }
                    ?>
                </tbody>       
            </table>
            <?php
        }
        ?>
    </div>
</div>
