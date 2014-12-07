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
 * Description of PartOfSpeech
 *
 * @author cehringfeld
 */
abstract class PartOfSpeech {

    const VERB = 0;
    const SUBSTANTIVE = 1;
    const ADJECTIVE = 2;
    const PHRASE = 3;
    const EXAMPLE = 4;

    public static function getParts() {
        $oClass = new ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }

    public static function getRoleNames() {
        return array(VERB => Yii::t('app', 'Verb'), SUBSTANTIVE => Yii::t('app', 'Substantive'), ADJECTIVE => Yii::t('app', 'Adjective'), PHRASE => Yii::t('app', 'Phrase'), EXAMPLE => Yii::t('app', 'Example'));
    }

}
