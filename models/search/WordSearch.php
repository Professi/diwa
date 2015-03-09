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
use app\models\Word;

/**
 * Description of WordSearch
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class WordSearch extends Word {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'language_id'], 'integer'],
            [['word'], 'safe'],
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
        $query = Word::find();
        $query->joinWith(['language']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'language_id' => $this->sortArray('language.shortname'),
                    'word' => $this->sortArray('word'),
                ],
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'language_id' => $this->language_id,
        ]);
        if (!empty(trim($this->word))) {
            $query->andWhere('word LIKE :word');
            $query->addParams([':word' => trim($this->word . '%')]);
        }
        return $dataProvider;
    }

}
