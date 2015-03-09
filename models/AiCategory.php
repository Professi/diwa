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
 * This is the model class for table "ai_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $importance
 *
 * @property Additionalinformation[] $additionalinformations
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class AiCategory extends \app\components\CustomActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ai_category';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'importance'], 'required'],
            [['importance'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'importance' => Yii::t('app', 'Importance'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdditionalInformations() {
        return $this->hasMany(AdditionalInformation::className(), ['category_id' => 'id']);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Category');
    }
    
    public static function getFilter() {
        return \yii\helpers\ArrayHelper::map(\app\models\AiCategory::find()->all(), 'id', 'name');
    }

}
