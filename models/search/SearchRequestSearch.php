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

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SearchRequest;

/**
 * SearchRequestSearch represents the model behind the search form about `app\models\SearchRequest`.
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class SearchRequestSearch extends SearchRequest {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'dictionary_id', 'searchMethod', 'useragent_id'], 'integer'],
            [['request', 'ipAddr', 'requestTime'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = SearchRequest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['requestTime'=>SORT_DESC],
                'attributes' => [
                    'searchMethod' => $this->sortArray('searchMethod'),
                    'dictionary_id' => $this->sortArray('dictionary_id'),
                    'request' => $this->sortArray('request'),
                    'requestTime' => $this->sortArray('requestTime'),
                ],
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'searchMethod' => $this->searchMethod,
            'dictionary_id' => $this->dictionary_id,
            'useragent_id' => $this->useragent_id,
            'requestTime' => $this->requestTime,
        ]);
        SearchRequestSearch::filterWord($query, $this->request);
        $query->andFilterWhere(['like', 'ipAddr', $this->ipAddr]);

        return $dataProvider;
    }

    public static function filterWord(&$q, $value) {
        if (!empty(trim($value))) {
            $q->andWhere('request LIKE :word');
            $q->addParams([':word' => trim($value . '%')]);
        }
    }

}
