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
use app\models\Shortcut;

/**
 * SearchRequestSearch represents the model behind the search form about `app\models\Shortcut`.
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class ShortcutSearch extends Shortcut {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'kind'], 'integer'],
            [['shortcut', 'name'], 'safe'],
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
        $query = Shortcut::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'kind' => $this->kind,
        ]);

        $query->andFilterWhere(['like', 'shortcut', $this->shortcut])
                ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
