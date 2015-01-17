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

use yii\data\ActiveDataProvider;
use app\models\UnknownWord;

/**
 * UnknownWordSearch represents the model behind the search form about `app\models\UnknownWord`.
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class UnknownWordSearch extends UnknownWord {

    public $searchMethod;
    public $dictionary;
    public $request;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'searchRequest_id'], 'integer'],
            [['searchMethod', 'dictionary', 'request'], 'safe']
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
        $query = UnknownWord::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'searchMethod' => $this->sortArray('searchMethod'),
                    'dictionary' => $this->sortArray('dictionary_id'),
                    'request' => $this->sortArray('request'),
                ],
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith(['searchRequest' => function ($q) {
                $q->andFilterWhere(['searchMethod' => $this->searchMethod,
                    'dictionary_id' => $this->dictionary]);
                if (!empty(trim($this->request))) {
                    $q->andWhere('request LIKE :word');
                    $q->addParams([':word' => trim($this->request . '%')]);
                }
            }]);
        return $dataProvider;
    }

}
