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

}
