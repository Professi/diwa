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

/**
 * Description of SearchMethod
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
abstract class SearchMethod {

    const FUZZY = 0; //Many likes
    const COMFORT = 1; //LIKE '%word%'
    const FAST = 2; //Fulltextsearch

    public static function getMethods() {
        return array(FUZZY, COMFORT, FAST);
    }

    public static function getMethodnames() {
        return array(FUZZY => Yii::t('app', 'Fuzzy search'), COMFORT => Yii::t('app', 'Comfort search'), FAST => Yii::t('app', 'Fast search'));
    }

}

//Suchmethoden: 
    //Fuzzy Search (drölfmilliarden likes)
    /*Komfortsuche(" WHERE " . $lang1 . " LIKE '%$word%' 
            //OR    " . $lang2 . " LIKE '%$word%'";*/
    /*Schnellsuche: Volltextsuche $sql = " WHERE MATCH(" . $lang1 . ", " . $lang2 . ") AGAINST(\"$word\")"; */
