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

/**
 * Description of SingleSearchForm
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class SingleSearchForm extends \app\models\forms\SearchForm {

    public $srcLang;
    public $targetLang;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['searchMethod', 'searchWord', 'srcLang', 'targetLang'], 'required'],
            [['searchWord'], 'string', 'max' => 255, 'min' => 2],
            [['dictionary', 'searchMethod', 'srcLang', 'targetLang'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'searchMethod' => Yii::t('app', 'Search method'),
            'dictionary' => Yii::t('app', 'Dictionary'),
            'searchWord' => Yii::t('app', 'Search word'),
            'srcLang' => Yii::t('app', 'Source language'),
            'targetLang' => \Yii::t('app', 'Target language')
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        $validate = parent::validate($attributeNames, $clearErrors);
        if ($validate) {
            $q = \app\models\Dictionary::find();
            $q->where('language1_id = :lang1 AND language2_id= :lang2');
            $q->orWhere('language1_id = :lang2 AND language2_id = :lang1');
            $q->addParams([':lang1' => $this->srcLang, ':lang2' => $this->targetLang]);
            $q->limit(1);
            $this->dictionary = $q->one();
            if (empty($this->dictionary)) {
                $this->addError('dictionary', Yii::t('app', 'No suitable dictionary found.'));
                $validate = false;
            } else {
                $this->dictionary = $this->dictionary->getId();
            }
        }
        return $validate;
    }

}
