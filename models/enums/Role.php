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
 * @author cehringfeld
 */
abstract class Role {

    const ADMIN = 0;
    const TERMINOLOGIST = 1;
    const NORMAL = 2;

    public static function getRoles() {
        return array(Role::ADMIN, Role::TRANSLATOR, Role::NORMAL);
    }

    public static function getRoleNames() {
        return array(Role::ADMIN => Yii::t('app', 'Administrator'), Role::TERMINOLOGIST => Yii::t('app', 'Terminologist'), Role::NORMAL => Yii::t('app', 'Normal User'));
    }

}
