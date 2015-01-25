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
 * This is the model class for table "ai_translation".
 *
 * @property integer $id
 * @property integer $ai_id
 * @property integer $translation_id
 *
 * @property Translation $translation
 * @property Additionalinformation $ai
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class AiTranslation extends \app\components\CustomActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ai_translation';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ai_id', 'translation_id'], 'integer'],
            [['ai_id', 'translation_id'], 'unique', 'targetAttribute' => ['ai_id', 'translation_id'], 'message' => 'The combination of Ai ID and Translation ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'additionalInformation' => Additionalinformation::getLabel(),
            'translation' => Translation::getLabel(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation() {
        return $this->hasOne(Translation::className(), ['id' => 'translation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalInformation() {
        return $this->hasOne(Additionalinformation::className(), ['id' => 'ai_id']);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Additionalinformation::getLabel() . ' ' . Yii::t('app', 'about a translation');
    }

}
