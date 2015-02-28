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

namespace app\components;

use Yii;
use yii\helpers\Html;

/**
 * Description of Html
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class CustomHtml {

    public static $buttonClass = 'small button';
    public static $groupClass = 'form-group';

    public static function defaultLink($text, $class, $action) {
        return \yii\helpers\Html::a(Yii::t('app', $text . ' {modelClass}', [
                            'modelClass' => $class::getLabel(),
                        ]), [$action], ['class' => static::$buttonClass]);
    }

    public static function link($text, $action) {
        return \yii\helpers\Html::a(Yii::t('app', $text), [$action], ['class' => static::$buttonClass]);
    }

    public static function sidebar($links) {
        $r = '<div class="row">';
        $r .= '<div id="sidebar" class="small-12 columns">';
        $r .= '<ul class="button-group even">';
        if (is_array($links)) {
            foreach ($links as $link) {
                $r .= static::generateListElement($link);
            }
        } else {
            $r .= static::generateListElement($links);
        }
        $r .= '</ul></div></div>';
        return $r;
    }

    public static function generateListElement($element) {
        return '<li>' . $element . '</li>';
    }

    public static function updateDeleteGroup($id) {
        return static::sidebar([static::link('Update', 'update'), Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $id], [
                        'class' => static::$buttonClass,
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
        ]])]);
    }

}
