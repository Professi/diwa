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

    public function translateRequest($searchRequest) {
        $data = $this->translateData($searchRequest->searchMethod, $searchRequest->request, $searchRequest->dictionary_id);
        if (empty($data)) {
            $this->createUnknownWord($searchRequest);
        }
        return $this->createDataProvider($data);
    }

    protected function createUnknownWord($searchRequest) {
        $u = \app\models\UnknownWord::find()->leftJoin('searchrequest sr', 'searchRequest_id=sr.id')
                ->where('sr.searchMethod=:sm AND LCASE(sr.request)=:word')
                ->params([':sm' => $searchRequest->searchMethod,
                    ':word' => strtolower($searchRequest->request)])
                ->one();
        if (empty($u)) {
            $unknown = new \app\models\UnknownWord();
            $unknown->searchRequest_id = $searchRequest->getPrimaryKey();
            $unknown->save();
        }
    }

    public function translateData($searchMethod, $searchWord, $dictionary = null) {
        $this->additionalParams = null;
        $data = [];
        if (is_numeric($dictionary)) {
            $this->dictionaryObj = \app\models\Dictionary::find()->where('id=:id')->params([':id' => $dictionary])->one();
        }
        if ($this->dictionaryObj != null && is_string($searchWord) && is_numeric($searchMethod)) {
            $this->searchWord = $searchWord;
            $cacheKey = $this->generateCacheKey($this->searchWord, $searchMethod, $this->dictionaryObj->getPrimaryKey());
            $data = $this->getCacheData($cacheKey);
            if ($data == false) {
                $data = $this->getMethodResult($searchMethod);
                if ($data != null) {
                    $this->setCacheData($data, $cacheKey, $this->getDependency($this->dictionaryObj->id));
                } else {
                    $data = [];
                }
            }
        }
        return $data;
    }

    public function translate($searchMethod, $searchWord, $dictionary = null) {
        return $this->createDataProvider($this->translateData($searchMethod, $searchWord, $dictionary));
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
        } else {
            $dataProvider = new ArrayDataProvider([
                'allModels' => [],
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
            $q = Translation::find()->asArray();
            $q->select(['id', 'word1_id', 'word2_id']);
            if (\Yii::$app->params['cacheTranslatedWords']) {
                $q->with('word1', 'word2');
            }
            if (!empty($wordsL1) && !empty($wordsL2)) {
                $q->where(['in', 'word1_id', $wordsL1])
                        ->orWhere(['in', 'word2_id', $wordsL2])
                        ->andwhere(['dictionary_id' => $this->dictionaryObj->id]);
            } else if (empty($wordsL1)) {
                $this->whereOneLang($q, 'word2_id', $wordsL2);
            } else if (empty($wordsL2)) {
                $this->whereOneLang($q, 'word1_id', $wordsL1);
            }
            if ($q->where != null) {
                $translations = $q->all();
            }
        }
        return $translations;
    }

    protected function whereOneLang(&$builder, $wordColumn, $arr) {
        $builder->where(['in', $wordColumn, $arr])
                ->andwhere(['dictionary_id' => $this->dictionaryObj->id]);
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
                        ->limit(1500)
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
        if (\Yii::$app->db->getDriverName() == 'mysql') {
            $where = '(MATCH(word) AGAINST(:word))';
        } else if (\Yii::$app->db->getDriverName() == 'pgsql') {
            $where = 'word @@ to_tsquery(\'simple\',:word)';
        }
        return $where;
    }

    protected function generateCacheKey($word, $method, $dictId) {
        return md5($word . '{' . $method . '}' . '[' . $dictId . ']');
    }

    protected function getDependency($dictId) {
        return new CachedDbDependency(['sql' => 'SELECT COUNT(*) FROM translation WHERE dictionary_id=:id', 'params' => [':id' => $dictId]]);
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
