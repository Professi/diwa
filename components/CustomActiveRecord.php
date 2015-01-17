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

/**
 * Description of CustomActiveRecord
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
abstract class CustomActiveRecord extends \yii\db\ActiveRecord {

    protected function sortArray($name) {
        return [
            'asc' => [
                $name => SORT_ASC,
            ],
            'desc' => [
                $name => SORT_DESC,
            ]
        ];
    }

    abstract public function getId();

    abstract public function setId($id);
}
