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

use app\models\enums\SearchMethod;
use yii\data\ArrayDataProvider;
use app\models\Translation;

/**
 * Description of Translator
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Translator extends \yii\base\Object {

    private $dictionaryObj = null;
    private $searchWord = null;
    private $cache = null;
    private $additionalParams = null;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->cache = \Yii::$app->cache;
    }

    public function translate($searchMethod, $searchWord, $dictionary = null) {
        $result = null;
        $this->additionalParams = null;
        if (is_numeric($dictionary)) {
            $this->dictionaryObj = \app\models\Dictionary::find()->where('id=:id')->params([':id' => $dictionary])->one();
        }
        if ($this->dictionaryObj != null && is_string($searchWord) && is_numeric($searchMethod)) {
            $this->searchWord = $searchWord;
            $cacheKey = $this->generateCacheKey($this->searchWord, SearchMethod::FAST);
            $data = $this->getCacheData($cacheKey);
            if ($data === false) {
                $result = $this->getMethodResult($searchMethod);
                if ($result != null) {
                    $this->setCacheData($result, $cacheKey, $this->getDependency($this->dictionaryObj->id));
                }
            }
        }
        return $this->createDataProvider($result);
    }

    protected function createDataProvider($result) {
        $dataProvider = null;
        if ($result != null) {
            $dataProvider = new ArrayDataProvider([
                'allModels' => $result,
                'sort' => [
                    'attributes' => ['word1', 'word2'],
                ],
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
        }
        return $dataProvider;
    }

    protected function getMethodResult($method) {
        $where = null;
        switch ($method) {
            case SearchMethod::COMFORT:
                $where = $this->comfortSearch();
                break;
            case SearchMethod::FUZZY:
                $where = $this->fuzzySearch();
                break;
            case SearchMethod::FAST:
                $where = $this->fastSearch();
                break;
        }
        return $this->getResult($where);
    }

    protected function getCacheData($key) {
        if ($this->cache != null) {
            return $this->cache->get($key);
        }
        return false;
    }

    protected function getResult($where) {
        $translations = [];
        if ($where != null) {
            $wordsL1 = $this->getWords($this->dictionaryObj->language1_id, $where);
            $wordsL2 = $this->getWords($this->dictionaryObj->language2_id, $where);
            $translations = Translation::find();
//                            ->leftJoin('word w1', 'w1.word=word1_id')
//                            ->leftJoin('word w2', 'w2.word=word1_id');
//                            ->where(['dictionary_id' => $this->dictionaryObj->id], ['in', 'w1.id', $wordsL1], ['in', 'w2.id', $wordsL2])

            $empty1 = false;
            if (empty($wordsL1)) {
                $empty1 = true;
                $translations->where(['in', 'word2_id', $wordsL1])
                        ->andwhere(['dictionary_id' => $this->dictionaryObj->id]);
            }
            $empty2 = false;
            if (empty($wordsL2)) {
                $empty2 = true;
                $translations->where(['in', 'word1_id', $wordsL1])
                        ->andwhere(['dictionary_id' => $this->dictionaryObj->id]);
            }
            if (!$empty1 && !$empty2) {
                $translations->where(['in', 'word1_id', $wordsL1])
                        ->orWhere(['in', 'word2_id', $wordsL2])
                        ->andwhere(['dictionary_id' => $this->dictionaryObj->id]);
            } 
//            print_r($translations->count());
//            print_r($translations->createCommand());
//                            ->all();
//            print_r($translations->createCommand()->getRawSql());
        }
        return $translations->all();
    }

    protected function getWords($lang, $where) {
        $params = [
            ':lang' => $lang,
        ];
        if ($this->additionalParams != null && is_array($this->additionalParams)) {
            $params = array_merge($params, $this->additionalParams);
        } else {
            $params[':word'] = $this->searchWord;
        }
        $words = \app\models\Word::find()->select(['id'])
                        ->where('language_id=:lang AND ' . $where)
                        ->params($params)
                        ->asArray()->all();
        $result = array();
        foreach ($words as $word) {
            $result[] = $word['id'];
        }
        return $result;
    }

    protected function setCacheData($data, $key, $dependency) {
        if ($this->cache != null) {
            $this->cache->set($key, $data, $this->getDuration(), $dependency);
        }
    }

    public function comfortSearch() {
        $this->additionalParams = [':word' => '%' . $this->searchWord . '%'];
        return 'word LIKE :word';
    }

    public function fuzzySearch() {
        $this->additionalParams = $this->getLevenshtein1($this->searchWord);
        $where = '';
        $first = true;
        foreach ($this->additionalParams as $key => $value) {
            if ($first) {
                $first = false;
            } else {
                $where .= ' OR ';
            }
            $where .= 'word LIKE ' . $key;
        }
        return $where;
    }

    public function fastSearch() {
        $where = '';
        if (strpos(\Yii::$app->db->dsn, 'mysql') == 0) {
            $where = '(MATCH(word) AGAINST(:word))';
        } else if (strpos(\Yii::$app->db->dsn, 'pgsql') == 0) {
            $where = '"word" @@ to_tsquery(:word)';
        }
        return $where;
    }

    protected function generateCacheKey($word, $method) {
        return md5($word . '[' . $method . ']');
    }

    protected function getDependency($dictId) {
        return new \yii\caching\DbDependency(['sql' => 'SELECT COUNT(*) FROM translation WHERE dictionary_id=:id', 'params' => [':id' => $dictId]]);
    }

    protected function getDuration() {
        return 0;
    }

    /**
     * https://gordonlesti.com/fuzzy-fulltext-search-with-mysql/
     * @param string $word
     * @return array
     */
    public function getLevenshtein1($word) {
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

}
