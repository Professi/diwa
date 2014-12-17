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
 * @propery string $agentHash
 */
class UserAgent extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'useragent';
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'agent' => Yii::t('app', 'User agent'),
            'agentHash' => Yii::t('app', 'Hash of user agent'),
        );
    }

    public function rules() {
        return [
            [['agent'], 'required'],
            [['agentHash'], 'unique'],
        ];
    }

    public static function createHash($agent) {
        return sha1($agent);
    }

    public function beforeValidate() {
        $this->agentHash = UserAgent::createHash($this->agent);
    }

}
