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
 * Description of Language
 *
 * @author cehringfeld
 * @property integer $id
 * @property string $shortname
 * @property string $name
 * 
 * @property Dictionary[] $dictionaries
 * @property Word[] $words
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Language extends \app\components\CustomActiveRecord {

    public static function tableName() {
        return 'language';
    }

    public function rules() {
        return [
            [['shortname', 'name'], 'required'],
            [['shortname',], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 255],
            [['shortname', 'name'], 'unique', 'targetAttribute' => ['shortname', 'name'],
                'message' => Yii::t('app', 'The combination of Shortname and Name has already been taken.')]
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'shortname' => Yii::t('app', 'Shortname'),
            'name' => Yii::t('app', 'name'),
        );
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
//        $db = Yii::$app->db;
//        if (strpos($db->dsn, 'pgsql') == 0) {
//            $db->createCommand('CREATE INDEX "ft_idx_word' . $this->getPrimaryKey() . '" ON "word" USING gin(to_tsvector('. Yii::t('app', $this->name). ',"word")) WHERE language_id=' . $this->getPrimaryKey() . ';')->execute();
//        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Language');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictionaries() {
        return $this->hasMany(Dictionary::className(), ['language2_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWords() {
        return $this->hasMany(Word::className(), ['language_id' => 'id']);
    }

}
