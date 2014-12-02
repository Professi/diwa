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
 * Description of SearchRequest
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 * @property integer $id
 * @property integer $dictionary_id
 * @property string $ipAddr
 * @property string $request
 * @property integer $useragent_id
 * @property datetime $timestamp
 */
class SearchRequest extends yii\db\ActiveRecord {

    public static function tableName() {
        return 'searchrequest';
    }

    public function attributeLabels() {
        return array(
            'id' => \yii::t('app', 'ID'),
            'requestTime' => \yii::t('app', 'Request time'),
            'dictionary' => \yii::t('app', 'Dictionary'),
            'ipAddr' => \yii::t('app', 'IP address'),
            'request' => \yii::t('app', 'Request'),
            'userAgent' => \yii::t('app', 'User agent'),
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

}
