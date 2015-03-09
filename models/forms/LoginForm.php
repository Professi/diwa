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

namespace app\models\forms;

use Yii;

//use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends \yii\base\Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $user = false;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
        );
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login() {
        $rc = false;
        if ($this->validate()) {
            $identity = new \app\components\UserIdentity();
            $identity->setUser($this->getUser());
            if (!(Yii::$app->user->loginByPassword($identity, $this->password, $this->rememberMe ? 3600 * 24 * 30 : 0))) {
                $this->addError('password', Yii::t('app', 'Incorrect username or password.'));
            } else {
                $rc = true;
            }
        }
        return $rc;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->user === false) {
            $this->user = \app\models\User::findByUsername($this->username);
        }
        return $this->user;
    }

}
