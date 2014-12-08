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
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
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
     * @todo no debug output...
     */
    public function processFile() {
        $fp = fopen($this->file->tempName, 'r');

        if ($fp) {
            set_time_limit(0);
            $translations = array();
            $delimiterSize = strlen($this->delimiters);
            while (($line = fgets($fp)) !== false) {
                $line = trim($line);
                $comment = strpos($line, '#');
                if (!$comment && $comment !== 0) {
                    $delPos = strpos($line, $this->delimiters);
                    if ($delPos) {
                        $translations[] = [trim(substr($line, 0, $delPos)), trim(substr($line, $delPos + $delimiterSize)), $this->dictionary];
                    }
                }
            }
            $con = Yii::$app->db;
            $con->createCommand()->batchInsert(\app\models\Translation::tableName(), ['word1', 'word2', 'dictionary_id'], $translations)->execute();
        } else {
            $this->addError('file', Yii::t('app', 'Your file is corrupted.'));
        }
    }

}
