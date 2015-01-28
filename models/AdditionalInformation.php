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

/**
 * This is the model class for table "additionalinformation".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $information
 * @property integer $source_id
 *
 * @property AiCategory $category
 * @property Src $source
 * @property AiTranslation[] $aiTranslations
 * @property AiWord[] $aiWords
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Additionalinformation extends \app\components\CustomActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'additionalinformation';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'source_id'], 'integer'],
            [['information'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'information' => Yii::t('app', 'Information'),
            'category' => Yii::t('app', 'Category'),
            'source' => Source::getLabel(),
            'translations' => Yii::t('app', 'Translations'),
            'words' => Yii::t('app', 'Words'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(AiCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource() {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAiTranslations() {
        return $this->hasMany(AiTranslation::className(), ['ai_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAiWords() {
        return $this->hasMany(AiWord::className(), ['ai_id' => 'id']);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Additional information');
    }

}
