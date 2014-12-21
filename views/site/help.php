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
        <h2 class='subheader'><?php echo Html::encode(Yii::t('app', 'Help')); ?></h2>
        <?php foreach ($categories as $key => $value) {
            ?><h3><?php echo $value; ?></h3>
            <table class="table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            <?php echo Yii::t('app', 'Shortcut'); ?>
                        </th>
                        <th>
                            <?php echo Yii::t('app', 'Name'); ?>
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
