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
use app\components\CachedDbDependency;

/**
 * Description of Dictionary
 *
 * @author cehringfeld
 * @property integer $id
 * @property integer $language1_id
 * @property integer $language2_id
 * @property boolean $active
 */
class Dictionary extends \app\components\CustomActiveRecord {

    public static function tableName() {
        return 'dictionary';
    }

    public function rules() {
        return [
            [['language1_id', 'language2_id'], 'required'],
            [['language1_id', 'language2_id'], 'integer'],
            [['active'], 'boolean'],
        ];
    }

    public function attributeLabels() {

        $lang1 = Language::getLabel() . ' 1';
        $lang2 = Language::getLabel() . ' 2';
        return array(
            'id' => self::getIdLabel(),
            'active' => Yii::t('app', 'Active'),
            'language1' => $lang1,
            'language2' => $lang2,
            'language1_id' => $lang1,
            'language2_id' => $lang2,
        );
    }

    public function getShortname() {
        return $this->language1->shortname . '-' . $this->language2->shortname;
    }

    public function getLongname() {
        return Yii::t('app', $this->language1->name) . '-' . Yii::t('app', $this->language2->name);
    }

    public function getLanguage1() {
        return $this->hasOne(Language::className(), array('id' => 'language1_id'));
    }

    public function getLanguage2() {
        return $this->hasOne(Language::className(), array('id' => 'language2_id'));
    }

    public static function cachedDictionaries() {
        $dep = new CachedDbDependency(['sql' => 'SELECT COUNT(*) FROM ' . self::tableName()]);
        $dicts = Yii::$app->db->cache(function ($db) {
            $q = \app\models\Dictionary::find()->with('language1', 'language2')->where(['active' => true]);
            return $q->all();
        }, 86400, $dep);
        return $dicts;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Dictionary');
    }

    public static function getFilter() {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'shortname');
    }

}
