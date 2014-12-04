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
use Yii;

/**
 * Description of Translation
 *
 * @author cehringfeld
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property integer $role
 * @property timestamp $lastLogin
 * 
 */
class User extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'user';
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'authKey' => Yii::t('app', 'Authentication key'),
            'role' => Yii::t('app', 'Role'),
            'lastLogin' => Yii::t('app', 'Last login')
        );
    }

    public function rules() {
        return [
            [['username', 'password', 'role'], 'required'],
            [['username'], 'unique'],
            [['username', 'password'], 'string', 'max' => 64]
        ];
    }

    public static function encryptPassword($password) {
        return \yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->authKey = \yii::$app->getSecurity()->generateRandomString();
            }
            if (strlen($this->password) <= 64 && strlen($this->password) > 0) {
                $this->password = $this->encryptPassword($this->password);
            } else {
                $this->password = User::model()->findByPk($this->id)->password;
            }
            return true;
        }
        return false;
    }

    public function getAuthKey() {
        return $this->authKey;
    }

    public function getId() {
        return $this->id;
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return User::findOne(array('username' => $username));
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

}
