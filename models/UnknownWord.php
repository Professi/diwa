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
 * Description of UnknownWord
 *
 * @author cehringfeld
 * @property integer $id
 * @property string $word
 * @property integer $searchRequest_id
 */
class UnknownWord extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'unknownword';
    }

    public function rules() {
        return [
            [['word', 'searchRequest_id'], 'required'],
            [['searchRequest_id'], 'integer'],
            [['word'], 'unique'],
            [['word'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'word' => Yii::t('app', 'Word'),
            'searchRequest' => Yii::t('app', 'Search Request'),
        );
    }

    public function getSearchRequest() {
        return $this->hasOne(\app\models\SearchRequest::className(), array('id' => 'searchRequest_id'));
    }

}
