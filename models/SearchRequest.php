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
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\Dictionary;

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
 * 
 * @property Dictionary $dictionary
 * @property Useragent $useragent
 * @property Unknownword[] $unknownwords
 * 
 */
class SearchRequest extends \app\components\CustomActiveRecord {

    public static function tableName() {
        return 'searchrequest';
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'requestTime',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => self::getIdLabel(),
            'searchMethod' => Yii::t('app', 'Search method'),
            'requestTime' => Yii::t('app', 'Request time'),
            'dictionary' => Dictionary::getLabel(),
            'ipAddr' => Yii::t('app', 'IP address'),
            'request' => SearchRequest::getLabel(),
            'userAgent' => UserAgent::getLabel(),
        );
    }

    public function rules() {
        return [
            [['request'], 'required'],
            [['dictionary_id', 'searchMethod', 'useragent_id'], 'integer'],
            [['requestTime'], 'safe'],
            [['request', 'ipAddr'], 'string', 'max' => 255]
        ];
    }

    public function getDictionary() {
        return $this->hasOne(Dictionary::className(), ['id' => 'dictionary_id']);
    }

    public function getUserAgent() {
        return $this->hasOne(UserAgent::className(), ['id' => 'useragent_id']);
    }

    public static function createRequest($method, $dictionary, $word) {
        $request = new SearchRequest();
        $request->request = $word;
        $request->searchMethod = $method;
        $request->dictionary_id = $dictionary;
        $request->ipAddr = \Yii::$app->request->getUserIP();
        $request->ipAddr = hash('sha256', $request->ipAddr); //'anonymize' ppl
        $userAgent = \Yii::$app->request->getUserAgent();
        if ($userAgent != null) {
            $hashedUseragent = UserAgent::createHash($userAgent);
            $userAg = UserAgent::findOne(['agentHash' => $hashedUseragent]);
            if ($userAg == null) {
                $userAg = UserAgent::createUserAgent($userAgent);
            }
            $request->useragent_id = $userAg->getPrimaryKey();
        }
        return $request;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Search request');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnknownwords() {
        return $this->hasMany(Unknownword::className(), ['searchRequest_id' => 'id']);
    }

}
