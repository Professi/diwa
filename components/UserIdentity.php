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

use app\models\User;

class UserIdentity implements \yii\web\IdentityInterface {

    private $user = null;

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getAuthKey() {
        return $this->user->getAuthKey();
    }

    public function getId() {
        return $this->user->getId();
    }

    public function validateAuthKey($authKey) {
        return $this->user->authKey === $authKey;
    }

    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public function login($user, $password) {
        $this->user = $user;
        if ($this->validatePassword($password)) {
            return true;
        }
        $this->user = null;
        return false;
    }

    public function getRole() {
        return $this->user->role;
    }

    public function loginAuthKey($user, $authKey) {
        $this->user = $user;
        if ($this->validateAuthKey($authKey)) {
            return true;
        }
        $this->user = null;
        return false;
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return User::findByUsername($username);
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->user->validatePassword($password);
    }

    /**
     * not needed
     * @param type $token
     * @param type $type
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException('Not implemented');
    }

}
