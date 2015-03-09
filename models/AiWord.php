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
use app\models\AdditionalInformation;

/**
 * This is the model class for table "ai_word".
 *
 * @property integer $id
 * @property integer $ai_id
 * @property integer $word_id
 *
 * @property Word $word
 * @property Additionalinformation $ai
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class AiWord extends \app\components\CustomActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ai_word';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ai_id', 'word_id'], 'required'],
            [['ai_id', 'word_id'], 'integer'],
            [['ai_id', 'word_id'], 'unique', 'targetAttribute' => ['ai_id', 'word_id'], 'message' => Yii::t('app', 'The combination of additional information and word has already been taken.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'additionalInformation' => AdditionalInformation::getLabel(),
            'word' => Word::getLabel(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWord() {
        return $this->hasOne(Word::className(), ['id' => 'word_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalInformation() {
        return $this->hasOne(AdditionalInformation::className(), ['id' => 'ai_id']);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel($plural = false) {
        return AdditionalInformation::getLabel($plural) . ' ' . Yii::t('app', 'about a word');
    }

}
