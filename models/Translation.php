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
use yii\data\SqlDataProvider;

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
        return $this->hasOne(Word::className(), ['id' => 'word1_id'])->from(Translation::tableName());
    }

    public function getWord2() {
        return $this->hasOne(Word::className(), ['id' => 'word2_id'])->from(Translation::tableName());
    }

    /**
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
        $where = '((w1.word LIKE :word) OR (w2.word LIKE :word)) AND (dictionary_id=:dictId)';
        $params = [':word' => '%' . $word . '%', ':dictId' => $dict];
        return Translation::createSqlDataprovider($where, $params);
    }

    public static function params($word, $dict) {
        return [':word' => '%' . $word . '%', ':dictId' => $dict];
    }

    public static function createSqlDataprovider($where, $params) {
        $count = Yii::$app->db->createCommand(Translation::basicSqlQueryCount() . $where, $params)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => Translation::basicSqlQuery() . $where,
            'params' => $params,
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $dataProvider;
    }

    public static function fastSearch($word, $dict) {
        $where = '';
        $params = [':word' => $word, ':dictId' => $dict];
        if (strpos(\Yii::$app->db->dsn, 'mysql') == 0) {
            $where = '(MATCH(w1.word) AGAINST(:word) OR MATCH(w2.word) AGAINST(:word)) AND dictionary_id=:dictId';
        } else if (strpos(\Yii::$app->db->dsn, 'pgsql') == 0) {
            //        $where = '"word1.word" @@ to_tsquery(:word) AND (dictionary_id=:dictId)';
        }
        return Translation::createSqlDataprovider($where, $params);
    }

    public static function fuzzySearch($word, $dict) {
        $params = Translation::getLevenshtein1($word);
        $where = '(';
        $first = true;
        foreach ($params as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $where .= ' OR ';
            }
            $where .= 'w1.word LIKE ' . $key
                    . ' OR w2.word LIKE ' . $key;
        }
        $where .= ') AND dictionary_id=:dictId';
        $params[':dictId'] = $dict;
        return Translation::createSqlDataprovider($where, $params);
    }

    public static function andDictionary($dict, &$query) {
        $query->andWhere('dictionary_id=:dictId', [':dictId' => $dict]);
    }

    public static function basicSqlQuery() {
        return 'SELECT t.id, w1.word AS word1 , w2.word AS word2 FROM translation t, word w1, word w2 WHERE t.word1_id=w1.id AND t.word2_id=w2.id AND ';
    }

    public static function basicSqlQueryCount() {
        return 'SELECT COUNT(*) FROM translation t, word w1, word w2 WHERE t.word1_id=w1.id AND t.word2_id=w2.id AND ';
    }

    public static function basicQuery() {
//        $query = Translation::basicQuery();
//        $query->where(['like', 'word1.word', $word]);
//        $query->orWhere(['like', 'word2.word', $word]);
//        Translation::andDictionary($dict, $query);
//        return Translation::dataProvider($query);
//        $query = Translation::find();
//        $query->select(['translation.id', 'word1_id','word2_id','word1.word w1', 'word2.word w2']);
//        $query->leftJoin('word word1', 'word1.id=' . Translation::tableName() . '.word1_id');
//        $query->leftJoin('word word2', 'word2.id=' . Translation::tableName() . '.word2_id');
////        $query->with(['word1', 'word2']);
//        $query->multiple = true;
//        return $query;
//        $query = Translation::basicQuery();
//        if (strpos(\Yii::$app->db->dsn, 'mysql') == 0) {
//            $query->where('MATCH(w1.word,w2.word) AGAINST(:word)', [':word' => $word]);
//        } else if (strpos(\Yii::$app->db->dsn, 'pgsql') == 0) {
//            
//        }
//        Translation::andDictionary($dict, $query);
//        return Translation::dataProvider($query);
    }

    public static function dataProvider($query) {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query
        ]);
        return $dataProvider;
    }

    /**
     * https://gordonlesti.com/fuzzy-fulltext-search-with-mysql/
     * @param string $word
     * @return array
     */
    public static function getLevenshtein1($word) {
        $words = array();
        for ($i = 0; $i < strlen($word); $i++) {
            // insertions
            $words[':wordI' . $i] = substr($word, 0, $i) . '_' . substr($word, $i) . '%';
            // deletions
            $words[':wordD' . $i] = substr($word, 0, $i) . substr($word, $i + 1) . '%';
            // substitutions
            $words[':wordS' . $i] = substr($word, 0, $i) . '_' . substr($word, $i + 1) . '%';
        }
        // last insertion
        $words[':wordLast'] = $word . '_';
        return $words;
    }

    //Suchmethoden: 
    //Fuzzy Search (drölfmilliarden likes)
    /* Schnellsuche: Volltextsuche $sql = " WHERE MATCH(" . $lang1 . ", " . $lang2 . ") AGAINST(\"$word\")"; */
    //Einzelwortsuche im Zusammenhang
    /* $sql = " WHERE " . $lang1 . " LIKE '$word' 
      OR    " . $lang2 . " LIKE '$word'
      OR    " . $lang1 . " LIKE '$word {_}'
      OR    " . $lang2 . " LIKE '$word {_}'
      OR    " . $lang1 . " LIKE '$word {__}'
      OR    " . $lang2 . " LIKE '$word {__}'";
     */
}
