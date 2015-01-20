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
use app\components\CustomActiveRecord;

/**
 * This is the model class for table "src".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 *
 * @property Translation[] $translations
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Source extends \app\components\CustomActiveRecord {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'link'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations() {
        return $this->hasMany(Translation::className(), ['src_id' => 'id']);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Source');
    }

    public static function tableName() {
        return 'src';
    }

}
