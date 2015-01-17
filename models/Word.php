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
 * Description of Word
 * @property integer $id
 * @property string $word
 * @property integer language_id
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Word extends \app\components\CustomActiveRecord {

    public function rules() {
        return [
            [['word'], 'string'],
            [['language_id'], 'integer']
        ];
    }

    public function attributeLabels() {
        $lang = Yii::t('app', 'Language');
        return array(
            'id' => Yii::t('app', 'ID'),
            'word' => Yii::t('app', 'Word'),
            'language' => $lang,
            'language_id' => $lang,
        );
    }

    public function getLanguage() {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    public static function tableName() {
        return 'word';
    }

    public function setValues($word, $langId) {
        $this->word = $word;
        $this->language_id = $langId;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

}
