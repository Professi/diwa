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

namespace app\models;

/**
 * Description of Translation
 *
 * @author cehringfeld
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property integer $role_id
 * @property date $lastLogin
 * 
 */
class User extends \yii\db\ActiveRecord {
    public static function tableName() {
        return 'user';
    }
    
    public function attributeLabels() {
        return array(
            'id'=> Yii::t('app','ID'),
            'username' => Yii::t('app','Username'),
            'password'=> Yii::t('app','Password'),
            'authKey'=> Yii::t('app', 'Authentication key'),
            'role'=> Yii::t('app','Role'),
            'createTime' => Yii::t('app','Create time'),
            'lastLogin'=>Yii::t('app','Last login')
        );
    }
    
    public function rules() {
        return [
            [['username','password','role_id'],'required'],
            [['username','authKey'],'unique'],
        ];
    }
    
    public static function encryptPassword($password) {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }
    
    public static function generateRandomString() {
        return Yii::$app->getSecurity()->generateRandomString();
    }

}
