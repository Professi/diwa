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
 * @property integer $language_id
 * @property array $additionalInformations temporal
 * 
 * @property Translation[] $translations
 * @property Language $language
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Word extends \app\components\CustomActiveRecord {

    public $additionalInformations;

    public function rules() {
        return [
            [['language_id'], 'integer'],
            [['word', 'language_id'], 'unique', 'targetAttribute' => ['word', 'language_id'], 'message' => Yii::t('app', 'The combination of Language ID and Word has already been taken.')]
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => self::getIdLabel(),
            'word' => self::getLabel(),
            'language' => Language::getLabel(),
            'language_id' => Language::getLabel(),
            'aiWords' => AiWord::getLabel(true),
            'additionalInformations' => \app\models\AdditionalInformation::getLabel(true),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAiWords() {
        return $this->hasMany(AiWord::className(), ['word_id' => 'id']);
    }

    public function getAdditionalInformations() {
        $arr = $this->getAiWords()->all();
        $output = '';
        foreach ($arr as $ai) {
            $additionalInfo = $ai->getAdditionalInformation()->one();
            $output .= $additionalInfo->toString() . '<br>';
        }
        return $output;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Word');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations() {
        return $this->hasMany(Translation::className(), ['word2_id' => 'id']);
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (parent::save($runValidation, $attributeNames)) {
            if (!$this->isNewRecord) {
                $this->deleteAllAiWords();
            }
            $this->processAdditionalInformations();
        }
        return true;
    }

    public function deleteAllAiWords() {
        foreach ($this->getAiWords()->select('id')->all() as $ai) {
            $ai->delete();
        }
    }

    public function beforeDelete() {
        $this->deleteAllAiWords();
        return parent::beforeDelete();
    }

    protected function processAdditionalInformations() {
        if ($this->additionalInformations != null && is_array($this->additionalInformations)) {
            foreach ($this->additionalInformations as $i) {
                $ai = new \app\models\AiWord();
                $ai->word_id = $this->getId();
                $ai->ai_id = $i;
                if (\app\models\AiWord::find()->where('ai_id = :aiId AND word_id = :wId')->params([':aiId' => $ai->ai_id, ':wId' => $ai->word_id])->count() >= 0) {
                    $ai->save();
                }
            }
        }
    }

}
