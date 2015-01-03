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

namespace app\models\forms;

use app\models\Word;
use app\models\Dictionary;
use app\models\Translation;

/**
 * Description of TranslationForm
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class TranslationForm extends \yii\base\Model {

    public $dictionary;
    public $word1;
    public $word2;
    private $wordObj1;
    private $wordObj2;
    private $dictObj;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['dictionary', 'word1', 'word2'], 'required'],
            [['dictionary'], 'integer'],
            [['word1', 'word2'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels() {
        return array(
            'dictionary' => Yii::t('app', 'Dictionary'),
            'word1' => Yii::t('app', 'Word {no}', ['{no}' => 1]),
            'word2' => Yii::t('app', 'Word {no}', ['{no}' => 2]),
        );
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        $rc = parent::validate($attributeNames, $clearErrors);
        if ($rc) {
            $this->dictObj = Dictionary::findOne($this->dictionary);
            $this->wordObj1 = $this->findWord($this->word1, $dictObj->language1_id);
            $this->wordObj2 = $this->findWord($this->word2, $dictObj->language2_id);
            if ($this->findTranslation($wordObj1, $wordObj2)) {
                $rc = false;
            }
        }
        return $rc;
    }

    public function create() {
        if (!($this->hasErrors())) {
            return $this->createTranslation();
        }
        return false;
    }

    public function findWord($word, $languageId) {
        return Word::find()->where(['word' => $word, 'language_id' => $languageId])->one();
    }

    protected function createTranslation() {
        $translation = new Translation();
        $translation->word1_id = $this->getWordId($this->wordObj1, $this->dictObj->language1_id);
        $translation->word2_id = $this->getWordId($this->wordObj2, $this->dictObj->language2_id);
        $translation->dictionary_id = $this->dictObj->getPrimaryKey();
        if (!(Translation::find()->where(['word1_id' => $translation->word1_id, 'word2_id' => $translation->word2_id, 'dictionary_id' => $translation->dictionary_id])->one())) {
            return $translation->save();
        }
        return false;
    }

    protected function getWordId($word, $languageId) {
        if ($word != null) {
            return $word->getPrimaryKey();
        }
        $wordObj = new Word();
        $wordObj->setValues($word, $languageId);
        $wordObj->save(false);
        return $wordObj->getPrimaryKey();
    }

    public function findTranslation($word1, $word2) {
        if (empty($word1) || empty($word2)) {
            return null;
        } else {
            return \app\models\Translation::find()->where(['word1_id' => $word1->getPrimaryKey(), 'word2_id' => $word2->getPrimaryKey(), 'dictionary_id' => $this->dictionary])->one();
        }
    }

}
