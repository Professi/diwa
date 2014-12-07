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
 * Description of Dictionary
 *
 * @author cehringfeld
 * @property integer $id
 * @property integer $langugage1_id
 * @property integer $language2_id
 */
class Dictionary extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'dictionary';
    }

    public function rules() {
        return [
            [['language1_id', 'language2_id'], 'required'],
            [['language1_id', 'language2_id'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'language1' => Yii::t('app', 'Language {no}', array('no' => 1)),
            'language2' => Yii::t('app', 'Language {no}', array('no' => 2)),
        );
    }

    public function getLanguage1() {
        return $this->hasOne(Language::className(), array('id' => 'language1_id'));
    }

    public function getLanguage2() {
        return $this->hasOne(Language::className(), array('id' => 'language2_id'));
    }

    public function validate($attributeNames = null, $clearErrors = true) {
        parent::validate($attributeNames, $clearErrors);
        if ($this->language1_id == $this->language2_id) {
            $this->addError('language1_id', Yii::t('app', 'You must choose two different languages.'));
        }
        return !$this->hasErrors();
    }

}
