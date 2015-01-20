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

namespace app\components;

use app\models\Word;
use app\models\Dictionary;
use Yii;

/**
 * File layout:
 * Lines beginning with # are comments
 * Word1SRC | Word2SRC SEPERATOR Word1Dest | Word2Dest
 * | is used for seperating relevances, e.g. to seperate a word in his single form with his plural form like 
 * process | processes
 * ; is used for words with the same sense like
 * masking paper; backing paper; release paper
 * In every line you must have the same occurences of | on source and dest but
 * you can have different occurences of ; on source and dest for example:
 * Abschlusskappe {f}; Endkappe {f} | Abschlusskappen {pl}; Endkappen {pl} :: end cap | end caps
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class TranslationFileProcessor {

    private $filepoint;
    private $generalSeparators;
    private $dictionary;
    private $wordSeparator;
    private $relevanceSeparator;
    private $translations = array();
    private $generalSeparatorsSize;
    private $errorArray = array();
    private $wordFindQuery = null;

    public function __construct($filepoint, $dictionaryId, $generalSeparators = '::', $wordSeparator = ';', $relevanceSeparator = '|') {
        $this->filepoint = $filepoint;
        $this->dictionary = Dictionary::findOne($dictionaryId);
        $this->generalSeparators = $generalSeparators;
        $this->generalSeparatorsSize = strlen($this->generalSeparators);
        $this->wordSeparator = $wordSeparator;
        $this->relevanceSeparator = $relevanceSeparator;
    }

    protected function getWordFindQuery() {
        return Word::find()->select(['id'])->where('word = :word AND language_id =: langID')->limit(1);
    }

    /**
     * @todo no debug output...
     */
    public function processFile() {
        set_time_limit(0);
        if ($this->filepoint) {
            $this->wordFindQuery = $this->getWordFindQuery();
            while (($line = fgets($this->filepoint)) !== false) {
                $this->separateTranslations($line);
            }
            $this->insertAllTranslations();
            $this->translations = array(); //to be save that they will be deleted
        } else {
            $this->errorArray['file'] = Yii::t('app', 'Your file is corrupted.');
        }
        return $this->errorArray;
    }

    protected function insertTranslation($con, $trans) {
        $con->createCommand()->batchInsert(\app\models\Translation::tableName(), ['word1_id', 'word2_id', 'dictionary_id'], $trans)->execute();
    }

    protected function insertAllTranslations() {
        $con = Yii::$app->db;
        $i = 1;
        $trans2 = array();
        foreach ($this->translations as $val) {
            $trans2[] = $val;
            $i++;
            if (($i % 5000) == 0) {
                $this->insertTranslation($con, $trans2);
                $trans2 = array();
            }
        }
        $this->insertTranslation($con, $trans2);
    }

    protected function separateTranslations($line) {
        $line = trim($line);
        if (!$this->isCommentLine($line)) {
            $delPos = strpos($line, $this->generalSeparators);
            if ($delPos) {
                $this->separateRelevances(trim(substr($line, 0, $delPos)), trim(substr($line, $delPos + $this->generalSeparatorsSize)));
            }
        }
    }

    protected function isCommentLine($line) {
        $comment = strpos($line, '#');
        if ($comment && $comment == 0) {
            return true;
        }
        return false;
    }

    protected function createOrFindWord($word, $langId) {
        $wordObj = $this->wordFindQuery()->params([':word' => $word, ':langID' => $langId])->one();
        if ($wordObj == null) {
            $wordObj = new Word();
            $wordObj->setValues($word, $langId);
            $wordObj->save();
        }
        return $wordObj;
    }

    protected function separateStrings($word, $needle) {
        $r = array();
        $wordRelCount = substr_count($word, $needle);
        if ($wordRelCount) {
            for ($i = 0; $i <= $wordRelCount; $i++) {
                $tempWord = '';
                $rel = strpos($word, $needle);
                if ($rel) {
                    $tempWord = trim(substr($word, 0, $rel));
                    $word = trim(substr($word, $rel + count($needle)));
                } else {
                    $tempWord = trim($word);
                }
                if (!empty($tempWord)) {
                    $r[] = $tempWord;
                }
            }
        } else {
            $r[] = $word;
        }
        return $r;
    }

    /**
     * 
     * @param array $arrWords
     * @param integer $langId
     * @return array
     */
    protected function persistWords($arrWords, $langId) {
        $pks = array();
        $count = count($arrWords);
        for ($i = 0; $i < $count; ++$i) {
            $word1Obj = $this->createOrFindWord($arrWords[$i], $langId);
            $pks[] = $word1Obj->getId();
        }
        return $pks;
    }

    /**
     * @TODO extend it for shortcuts
     * bottleneck, to much SQL selects
     * @param type $word1
     * @param type $word2
     */
    protected function separateRelevances($word1, $word2) {
        $flash = '';
        $arrRels1 = $this->separateStrings($word1, $this->relevanceSeparator);
        $arrRels2 = $this->separateStrings($word2, $this->relevanceSeparator);
        $relcount = count($arrRels1);
        if ($relcount === count($arrRels2)) {
            for ($i = 0; $i < $relcount; $i++) {
                $pks1 = $this->persistWords($this->separateStrings($arrRels1[$i], $this->wordSeparator), $this->dictionary->language1_id);
                $pks2 = $this->persistWords($this->separateStrings($arrRels2[$i], $this->wordSeparator), $this->dictionary->language2_id);
                foreach ($pks1 as $val) {
                    foreach ($pks2 as $val2) {
                        $this->translations[] = array($val, $val2, $this->dictionary->id);
                    }
                }
            }
        } else {
            $flash .= $word1 . ' ' . $this->generalSeparators . ' ' . $word2 . '<br/>';
            $word1Obj = $this->createOrFindWord($word1, $this->dictionary->language1_id);
            $word2Obj = $this->createOrFindWord($word2, $this->dictionary->language2_id);
            $this->translations[] = array($word1Obj->getId(), $word2Obj->getId(), $this->dictionary->id);
        }
        if (!empty($flash)) {
            Yii::$app->user->setFlash('success', Yii::t('app', 'Bad datasets:') . '<br/>' . $flash);
        }
    }

    public function getErrors() {
        return $this->errorArray;
    }

}
