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

use Yii;
use app\models\Word;

class TranslationUploadForm extends \yii\base\Model {

    public $dictionary;
    public $file;
    public $delimiters = '::';

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['dictionary', 'file', 'delimiters'], 'required'],
            [['dictionary'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt', 'maxFiles' => 1, 'maxSize' => $this->getSizeLimit()],
        ];
    }

    public function attributeLabels() {
        return array(
            'dictionary' => Yii::t('app', 'Dictionary'),
            'file' => Yii::t('app', 'File'),
            'delimiters' => Yii::t('app', 'Delimiters'),
        );
    }

    /**
     * Returns the maximum size allowed for uploaded files.
     * This is determined based on three factors:
     *
     * - 'upload_max_filesize' in php.ini
     * - 'MAX_FILE_SIZE' hidden field
     * - [[maxSize]]
     *
     * @return integer the size limit for uploaded files.
     */
    public function getSizeLimit() {
        $limit = $this->sizeToBytes(ini_get('post_max_size'));
        return $limit;
    }

    /**
     * Converts php.ini style size to bytes
     * Copied from FileValidator
     * @param string $sizeStr $sizeStr
     * @return int
     */
    private function sizeToBytes($sizeStr) {
        switch (substr($sizeStr, -1)) {
            case 'M':
            case 'm':
                return (int) $sizeStr * 1048576;
            case 'K':
            case 'k':
                return (int) $sizeStr * 1024;
            case 'G':
            case 'g':
                return (int) $sizeStr * 1073741824;
            default:
                return (int) $sizeStr;
        }
    }

    /**
     * @todo no debug output...
     */
    public function processFile() {
        $fp = fopen($this->file->tempName, 'r');
        if ($fp) {
            set_time_limit(0);
            $translations = array();
            $delimiterSize = strlen($this->delimiters);
            $dict = \app\models\Dictionary::findOne($this->dictionary);
            while (($line = fgets($fp)) !== false) {
                $line = trim($line);
                $comment = strpos($line, '#');
                if (!$comment && $comment !== 0) {
                    $delPos = strpos($line, $this->delimiters);
                    if ($delPos) {
                        $word1 = new Word();
                        $word2 = new Word();
                        $word1->word = trim(substr($line, 0, $delPos));
                        $word1->language_id = $dict->language1_id;
                        $word2->word = trim(substr($line, $delPos + $delimiterSize));
                        $word2->language_id = $dict->language2_id;
                        $word3 = Word::findOne(['word' => $word1->word, 'language_id' => $word1->language_id]);
                        if ($word3 == null) {
                            $word1->save(false);
                            $word3 = $word1;
                        }
                        $word4 = Word::findOne(['word' => $word2->word, 'language_id' => $word2->language_id]);
                        if ($word4 == null) {
                            $word2->save(false);
                            $word4 = $word2;
                        }
                        $translations[] = array($word3->getPrimaryKey(), $word4->getPrimaryKey(), $this->dictionary);
                    }
                }
            }
            $con = Yii::$app->db;
            $i = 1;
            $trans2 = array();
            foreach ($translations as $val) {
                $trans2[] = $val;
                $i++;
                if (($i % 5000) == 0) {
                    $this->insertTranslation($con, $trans2);
                    $trans2 = array();
                }
            }
            $this->insertTranslation($con, $trans2);
        } else {
            $this->addError('file', Yii::t('app', 'Your file is corrupted.'));
        }
    }

    protected function insertTranslation($con, $trans) {
        $con->createCommand()->batchInsert(\app\models\Translation::tableName(), ['word1_id', 'word2_id', 'dictionary_id'], $trans)->execute();
    }

}
