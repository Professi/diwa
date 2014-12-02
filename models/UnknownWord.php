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
 * Description of UnknownWord
 *
 * @author cehringfeld
 * @property integer $id
 * @property string $word
 * @property integer $dictionary_id
 */
class UnknownWord extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'unknownword';
    }

    public function rules() {
        return [
            [['word', 'dictionary_id'], 'required'],
            [['dictionary_id'], 'integer'],
            [['word'], 'unique'],
            [['word'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => \yii::t('app', 'ID'),
            'word' => \yii::t('app', 'Word'),
            'dictionary' => \yii::t('app', 'Dictionary'),
        );
    }

    public function getDictionary() {
        return $this->hasOne(\app\models\Dictionary::className(), array('id' => 'dictionary_id'));
    }

}
