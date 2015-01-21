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

/**
 * Description of TranslationSearch
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Translation;

/**
 * TranslationSearch represents the model behind the search form about `app\models\Translation`.
 */
class TranslationSearch extends Translation {

    public $language1 = '';
    public $word1Term = '';
    public $language2 = '';
    public $word2Term = '';
    public $source = '';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['language1', 'word1Term', 'language2', 'word2Term', 'source'], 'safe'],
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
        $query = Translation::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'word1Term' => $this->sortArray('word1.word'),
                    'word2Term' => $this->sortArray('word2.word'),
                    'language1' => $this->sortArray('dictionary.language1_id'),
                    'language2' => $this->sortArray('dictionary.language2_id'),
                    'source' => $this->sortArray('src_id'),
                ],
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->joinWith(['dictionary', 'word1', 'word2']);
            return $dataProvider;
        }
        $query->joinWith(['dictionary' => function ($q) {
                $q->andFilterWhere(['dictionary.language1_id' => $this->language1,
                    'dictionary.language2_id' => $this->language2,
                    'src_id' => $this->source,
                ]);
            }, 'word1' => function ($q) {
                $this->filterWord($this->word1Term, 'word1', $q);
            }, 'word2' => function ($q) {
                $this->filterWord($this->word2Term, 'word2', $q);
            }]);
                return $dataProvider;
            }

            public function filterWord($value, $name, &$query) {
                if (!empty($value)) {
                    $q->andWhere($name . '.word LIKE :' . $name);
                    $q->addParams([':' . $name => $value . '%']);
                }
            }

        }
        