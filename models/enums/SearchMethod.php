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

namespace app\models\enums;

use Yii;

/**
 * Description of SearchMethod
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
abstract class SearchMethod {

    const FUZZY = 0;
    const COMFORT = 1;
    const FAST = 2;
    const NORMAL = 3;

    public static function getMethods() {
        return array(SearchMethod::FUZZY, SearchMethod::COMFORT, SearchMethod::FAST, SearchMethod::NORMAL);
    }

    public static function getMethodnames() {
        return array(SearchMethod::NORMAL => Yii::t('app', 'Normal search'), SearchMethod::FAST => Yii::t('app', 'Full text search'), SearchMethod::FUZZY => Yii::t('app', 'Fuzzy search'), SearchMethod::COMFORT => Yii::t('app', 'Comfort search'));
    }

    public static function getDescription($method) {
        $r = '';
        switch ($method) {
            case self::FUZZY:
                $r = self::getFuzzyDesc();
                break;
            case self::COMFORT:
                $r = self::getComfortDesc();
                break;
            case self::FAST:
                $r = self::getFastDesc();
                break;
            case self::NORMAL:
                $r = self::getNormalDesc();
                break;
        }
        return $r;
    }

    public static function getFuzzyDesc() {
        return Yii::t('app', 'The Levenshtein algorithmus is used for fuzzy search. Depending on the word length, it can be really slow. If you enter "Tier", it\'s will also show you hits for "Toer" or "Tor".');
    }

    public static function getComfortDesc() {
        return Yii::t('app', 'It shows every hit which contains the searched word.');
    }

    public static function getFastDesc() {
        return Yii::t('app', 'If you enter "Berlin Paris" it will show you every hit which contains "Berlin" or "Paris".');
    }

    public static function getNormalDesc() {
        return Yii::t('app', 'It shows every hit which begins with the searched word.');
    }

}
