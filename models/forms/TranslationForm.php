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
use Yii;

/**
 * Description of TranslationForm
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class TranslationForm extends \yii\base\Model {

    public $dictionary_id;
    public $word1;
    public $word2;
    private $wordObj1;
    private $wordObj2;
    public $src_id = null;
    private $dictObj;
    public $create = true;
    public $translationId = null;
    public $additionalInformations;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['dictionary_id', 'word1', 'word2'], 'required'],
            [['dictionary_id', 'src_id'], 'integer'],
            [['word1', 'word2'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels() {
        return array(
            'dictionary' => Dictionary::getLabel(),
            'dictionary_id' => Dictionary::getLabel(),
            'word1' => Word::getLabel() . ' 1',
            'word2' => Word::getLabel() . ' 2',
            'src_id' => \app\models\Source::getLabel(),
            'additionalInformations' => Yii::t('app', 'Additional informations'),
        );
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        $rc = parent::validate($attributeNames, $clearErrors);
        if ($rc) {
            $this->dictObj = Dictionary::findOne($this->dictionary_id);
            $this->wordObj1 = $this->findWord($this->word1, $this->dictObj->language1_id);
            $this->wordObj2 = $this->findWord($this->word2, $this->dictObj->language2_id);
            $trans = $this->findTranslation($this->wordObj1, $this->wordObj2);
            if ($trans && $this->create) {
                Yii::$app->user->setFlash('failMsg', Yii::t('app', 'Dataset already exists.'));
                $rc = false;
            } else {
                $this->translationId = $trans->getId();
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
        $rc = false;
        if (!$this->translationId) {
            $translation = new Translation();
            $translation->word1_id = $this->getWordId($this->wordObj1, $this->word1, $this->dictObj->language1_id);
            $translation->word2_id = $this->getWordId($this->wordObj2, $this->word2, $this->dictObj->language2_id);
            $translation->dictionary_id = $this->dictObj->getId();
            $translation->src_id = $this->src_id;
            if (!(Translation::find()->where(['word1_id' => $translation->word1_id, 'word2_id' => $translation->word2_id, 'dictionary_id' => $translation->dictionary_id])->one())) {
                $rc = $translation->save();
                $this->translationId = $translation->getId();
            }
        } else {
            $rc = true;
        }
        return $rc;
    }

    protected function getWordId($word, $str, $languageId) {
        if ($word instanceof Word) {
            return $word->getId();
        }
        $wordObj = new Word();
        $wordObj->setValues($str, $languageId);
        $wordObj->insert();
        return $wordObj->getId();
    }

    public function findTranslation($word1, $word2) {
        if (empty($word1) || empty($word2)) {
            return null;
        } else {
            return \app\models\Translation::find()->where(['word1_id' => $word1->getPrimaryKey(), 'word2_id' => $word2->getPrimaryKey(), 'dictionary_id' => $this->dictionary_id])->one();
        }
    }

    public function getTranslationId() {
        return $this->translationId;
    }

}
