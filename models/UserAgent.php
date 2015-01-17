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
 * Description of UserAgent
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 * @property integer $id
 * @property string $agent
 * @property string $agentHash
 */
class UserAgent extends \app\components\CustomActiveRecord {

    public static function tableName() {
        return 'useragent';
    }

    public function attributeLabels() {
        return array(
            'id' => self::getIdLabel(),
            'agent' => UserAgent::getLabel(),
            'agentHash' => Yii::t('app', 'Hash of user agent'),
        );
    }

    public function rules() {
        return [
            [['agentHash'], 'unique'],
            [['agentHash'], 'string', 'max' => 255],
        ];
    }

    public static function createHash($agent) {
        return sha1($agent);
    }

    public function beforeValidate() {
        $this->agentHash = UserAgent::createHash($this->agent);
    }

    public static function createUserAgent($userAgent) {
        $userAg = new UserAgent();
        $userAg->agent = $userAgent;
        $userAg->agentHash = UserAgent::createHash($userAgent);
        $userAg->save(false);
        return $userAg;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'User agent');
    }

}
