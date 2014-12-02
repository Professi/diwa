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
 * Description of Translation
 *
 * @author cehringfeld
 * @property integer $id
 * @property integer $dictionary_id
 * @property string $word1
 * @property string $word2
 * @property integer $partOfSpeech_id 
 * 
 */
class Translation extends \yii\db\ActiveRecord {

    public function rules() {
        return [
            [['id', 'dictionary_id'], 'integer', 'required'],
            [['word1', 'word2'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => \yii::t('app', 'ID'),
            'dictionary' => \yii::t('app', 'Dictionary'),
            'word1' => \yii::t('app', 'Word {no}', array('{no}' => 1)),
            'word2' => \yii::t('app', 'Word {no}', array('{no}' => 2)),
            'partOfSpeech' => \yii::t('app', 'Part of speech'),
        );
    }

    public static function tableName() {
        return 'translation';
    }

    public function getDictionary() {
        return $this->hasOne(Dictionary::className(), ['id' => 'dictionary_id']);
    }

    public function getPartOfSpeech() {
        return $this->hasOne(\PartOfSpeech::className(), ['id' => 'partOfSpeech_id']);
    }

}
