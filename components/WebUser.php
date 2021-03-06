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
 * Description of WebUser
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class WebUser extends \yii\web\User {

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $role RollenID
     * @return bool Permission granted?
     */
    public function checkAccess($role, $params = null) {
        if ($this->getIdentity() == null || !$this->getIdentity()->getId()) {
            return false;
        }
        return ($role === $this->getIdentity()->getRole());
    }

    public function can($permissionName, $params = array(), $allowCaching = true) {
        $access = $this->checkAccess($permissionName, $params);
        return $access;
    }

    public function isGuest() {
        return $this->isGuest;
    }

    public function setFlash($key, $value, $removeAfterAccess = true) {
        \Yii::$app->getSession()->setFlash($key, $value, $removeAfterAccess);
    }

    public function getFlash($key, $defaultValue = NULL, $delete = true) {
        return \Yii::$app->getSession()->getFlash($key, $defaultValue, $delete);
    }

    public function hasFlash($key) {
        return \Yii::$app->getSession()->hasFlash($key);
    }

    public function isAdmin() {
        return $this->checkRole(\app\models\enums\Role::ADMIN);
    }

    public function isTerminologist() {
        return $this->checkRole(\app\models\enums\Role::TERMINOLOGIST);
    }

    public function isAdvancedUser() {
        return ($this->isAdmin() || $this->isTerminologist());
    }

    public function isNormalUser() {
        return $this->checkRole(\app\models\enums\Role::NORMAL);
    }

    private function checkRole($role) {
        return ($this->getIdentity() != null && $this->getIdentity()->getRole() == $role);
    }

    public function login(\yii\web\IdentityInterface $identity, $duration = 0) {
        if (parent::login($identity, $duration)) {
            $user = $identity->getUser();
            $user->getBehavior('timestamp')->touch('lastLogin');
            $identity->getUser()->update();
            return true;
        }
        return false;
    }

    public function loginByPassword(\yii\web\IdentityInterface $identity, $password, $duration = 0) {
        if ($identity->loginByPassword($password)) {
            return $this->login($identity, $duration);
        }
        return false;
    }

}
