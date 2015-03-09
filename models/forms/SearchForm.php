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
 * Description of SearchForm
 * 
 * @author cehringfeld
 * @property integer $searchMethod
 * @property integer $dictionary
 * @property integer $maxEntries
 * @property string $searchWord
 */
class SearchForm extends \yii\base\Model {

    public $searchMethod = 3;
    public $dictionary = 1;
    public $searchWord = '';

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['searchMethod', 'dictionary', 'searchWord'], 'required'],
            [['searchWord'], 'string', 'max' => 255, 'min' => 2],
            [['dictionary', 'searchMethod'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return array(
            'searchMethod' => Yii::t('app', 'Search method'),
            'dictionary' => Yii::t('app', 'Dictionary'),
            'searchWord' => Yii::t('app', 'Search word'),
        );
    }

    public function beforeValidate() {
        $this->searchWord = trim($this->searchWord);
        return parent::beforeValidate();
    }

}
