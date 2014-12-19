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
use app\models\enums\SearchMethod;
use yii\db\Query;

/**
 * Description of Translation
 *
 * @author cehringfeld
 * @property integer $id
 * @property integer $dictionary_id
 * @property integer $word1_id
 * @property integer $word2_id
 * 
 */
class Translation extends \yii\db\ActiveRecord {

    public function rules() {
        return [
            [['dictionary_id'], 'integer'],
            [['word1_id', 'word2_id'], 'integer'],
            [['dictionary_id'], 'required'],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'dictionary' => Yii::t('app', 'Dictionary'),
            'word1' => Yii::t('app', 'Word {no}', array('no' => 1)),
            'word2' => Yii::t('app', 'Word {no}', array('no' => 2)),
        );
    }

    public static function tableName() {
        return 'translation';
    }

    public function getDictionary() {
        return $this->hasOne(Dictionary::className(), ['id' => 'dictionary_id'])->one();
    }

    public function getWord1() {
        return $this->hasOne(Word::className(), ['id' => 'word1_id'])->from(Translation::tableName() . ' w1');
    }

    public function getWord2() {
        return $this->hasOne(Word::className(), ['id' => 'word2_id'])->from(Translation::tableName() . ' w2');
    }

    /**
     * War inside my head...............................................................................
     * So much query bullshit gedöns!
     * @param type $searchMethod
     * @param type $searchWord
     * @param type $dictionary
     * @return type
     */
    public static function searchWords($searchMethod, $searchWord, $dictionary) {
        $result = array();
        switch ($searchMethod) {
            case SearchMethod::COMFORT:
                $result = Translation::comfortSearch($searchWord, $dictionary);
                break;
            case SearchMethod::FUZZY:
                $result = Translation::fuzzySearch($searchWord, $dictionary);
                break;
            case SearchMethod::FAST:
                $result = Translation::fastSearch($searchWord, $dictionary);
                break;
        }
        return $result;
    }

    public static function comfortSearch($word, $dict) {
        $query = Translation::basicQuery();
        $query->where(['like', 'w1.word', $word]);
        $query->orWhere(['like', 'w2.word', $word]);
        Translation::andDictionary($dict, $query);
        return Translation::dataProvider($query);
    }

    public static function fastSearch($word, $dict) {

        $query = Translation::basicQuery();
        if (strpos(\Yii::$app->db->dsn, 'mysql') == 0) {
            $query->where('MATCH(word1.word) AGAINST(:word)', [':word' => $word]);
        } else if (strpos(\Yii::$app->db->dsn, 'pgsql')) {
            
        }
        Translation::andDictionary($dict, $query);
        return Translation::dataProvider($query);
    }

    public static function fuzzySearch($word, $dict) {
        $query = Translation::basicQuery();


        Translation::andDictionary($dict, $query);
        return Translation::dataProvider($query);
    }

    public static function andDictionary($dict, &$query) {
        $query->andWhere('dictionary_id=:dictId', [':dictId' => $dict]);
    }

    public static function basicQuery() {
        $query = Translation::find();
        $query->joinWith('word1', true);
        $query->joinWith('word2', true);
//        $query->leftJoin('word word1', 'word1.id=' . Translation::tableName() . '.word1_id');
//        $query->leftJoin('word word2', 'word2.id=' . Translation::tableName() . '.word2_id');
//        $query->with(['word1', 'word2']);
        return $query;
    }

    public static function dataProvider($query) {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query
        ]);
        return $dataProvider;
    }

    //Suchmethoden: 
    //Fuzzy Search (drölfmilliarden likes)
    /* Schnellsuche: Volltextsuche $sql = " WHERE MATCH(" . $lang1 . ", " . $lang2 . ") AGAINST(\"$word\")"; */
}
