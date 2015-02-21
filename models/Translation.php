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
class Translation extends \app\components\CustomActiveRecord {

    public function rules() {
        return [
            [['dictionary_id', 'word1_id', 'word2_id', 'src_id'], 'integer'],
            [['dictionary_id'], 'required'],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => self::getIdLabel(),
            'dictionary' => Dictionary::getLabel(),
            'word1' => Word::getLabel() . ' 1',
            'word2' => Word::getLabel() . ' 2',
            'language1' => Language::getLabel() . ' 1',
            'language2' => Language::getLabel() . ' 2',
            'src_id' => Source::getLabel(),
            'source' => Source::getLabel(),
            'aiTranslations' => AiTranslation::getLabel(),
        );
    }

    public static function tableName() {
        return 'translation';
    }

    public function getDictionary() {
        return $this->hasOne(Dictionary::className(), ['id' => 'dictionary_id']);
    }

    public function getWord1() {
        return $this->hasOne(Word::className(), ['id' => 'word1_id'])->from(Word::tableName() . ' word1');
    }

    public function getWord2() {
        return $this->hasOne(Word::className(), ['id' => 'word2_id'])->from(Word::tableName() . ' word2');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAiTranslations() {
        return $this->hasMany(AiTranslation::className(), ['translation_id' => 'id']);
    }

    public function getAdditionalInformations() {
        $arr = $this->getAiTranslations()->all();
        $output = '';
        foreach ($arr as $ai) {
            $additionalInfo = $ai->getAdditionalInformation()->one();
            $output .= $additionalInfo->getCategory()->one()->name . ' - ' . $additionalInfo->information . '<br>';
        }
        return $output;
    }

    public function getWord1Term() {
        return empty($this->word1) ? '' : $this->word1->word;
    }

    public function getWord2Term() {
        return empty($this->word2) ? '' : $this->word2->word;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Translation');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource() {
        return $this->hasOne(Source::className(), ['id' => 'src_id']);
    }

}
