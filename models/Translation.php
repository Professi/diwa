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
use app\models\enums\SearchMethod;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * Description of Translation
 *
 * @author cehringfeld
 * @property integer $id
 * @property integer $dictionary_id
 * @property integer $word1_id
 * @property integer $word2_id
 * 
 */
class Translation extends \yii\db\ActiveRecord {

    public function rules() {
        return [
            [['dictionary_id'], 'integer'],
            [['word1_id', 'word2_id'], 'integer'],
            [['dictionary_id'], 'required'],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'dictionary' => Yii::t('app', 'Dictionary'),
            'word1' => Yii::t('app', 'Word {no}', ['no' => 1]),
            'word2' => Yii::t('app', 'Word {no}', ['no' => 2]),
            'language1' => Yii::t('app', 'Language {no}',['no'=>1]),
            'language2' => Yii::t('app', 'Language {no}',['no'=>2]),
        );
    }

    public static function tableName() {
        return 'translation';
    }

    public function getDictionary() {
        return $this->hasOne(Dictionary::className(), ['id' => 'dictionary_id'])->one();
    }

    public function getWord1() {
        return $this->hasOne(Word::className(), ['id' => 'word1_id']);
    }

    public function getWord2() {
        return $this->hasOne(Word::className(), ['id' => 'word2_id']);
    }

}
