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
 * Description of SearchRequest
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 * @property integer $id
 * @property integer $dictionary_id
 * @property string $ipAddr
 * @property integer $searchMethod
 * @property string $request
 * @property integer $useragent_id
 * @property datetime $timestamp
 */
class SearchRequest extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'searchrequest';
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'searchMethod' => Yii::t('app', 'Search method'),
            'requestTime' => Yii::t('app', 'Request time'),
            'dictionary' => Yii::t('app', 'Dictionary'),
            'ipAddr' => Yii::t('app', 'IP address'),
            'request' => Yii::t('app', 'Request'),
            'userAgent' => Yii::t('app', 'User agent'),
        );
    }

    public function rules() {
        return [
            [['request'], 'required'],
        ];
    }

    public function getDirectory() {
        return $this->hasOne(Directory::className(), ['id' => 'dictionary_id']);
    }

    public function getUserAgent() {
        return $this->hasOne(UserAgent::className(), ['id' => 'useragent_id']);
    }

    public static function createRequest($method, $dictionary, $word) {
        $request = new SearchRequest();
        $request->dictionary_id = $dictionary;
        $request->request = $word;
        $request->method = $method;
        $request->ipAddr = \Yii::$app->request->getUserIP();
        $userAgent = \Yii::$app->request->getUserAgent();
        $hashedUseragent = UserAgent::createHash($userAgent);
        $userAg = UserAgent::findOne(['agentHash' => $hashedUseragent]);
        if ($userAg == null) {
            $userAg = new UserAgent();
            $userAg->agent = $userAgent;
            $userAg->save();
        }
        $request->useragent_id = $userAg->getPrimaryKey();
        return $request;
    }

}
