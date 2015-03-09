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
use app\models\enums\ShortcutCategory;

/**
 * Description of Branches
 * @property integer $id
 * @property string $shortcut
 * @property string $name
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Shortcut extends \app\components\CustomActiveRecord {

    public static function tableName() {
        return 'shortcut';
    }

    public function rules() {
        return [
            [['shortcut'], 'required'],
            [['shortcut'], 'unique'],
            [['shortcut', 'name', 'kind'], 'safe'],
            [['kind'], 'integer'],
            [['shortcut', 'name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return array(
            'id' => self::getIdLabel(),
            'shortcut' => Yii::t('app', 'Shortcut'),
            'name' => Yii::t('app', 'Name'),
            'kind' => Yii::t('app', 'Kind'),
        );
    }

    public static function defaultShortcuts() {
        Shortcut::createShortcuts(Shortcut::defaultUsageNames(), ShortcutCategory::USAGE);
        Shortcut::createShortcuts(Shortcut::defaultBranchNames(), ShortcutCategory::BRANCH);
        Shortcut::createShortcuts(Shortcut::defaultPartOfSpeeches(), ShortcutCategory::PARTOFSPEECH);
    }

    public static function createShortcuts($array, $kind) {
        foreach ($array as $key => $value) {
            $shortcut = new Shortcut();
            $shortcut->shortcut = $key;
            $shortcut->name = $value;
            $shortcut->kind = $kind;
            $shortcut->save();
        }
    }

    public static function defaultUsageNames() {
        return array(
            '[alt]' => Yii::t('app', 'old German spelling'),
            '[obs.]' => Yii::t('app', 'obsolete'),
            '[Am.]' => Yii::t('app', 'American English'),
            '[Br.]' => Yii::t('app', 'British English'),
            '[Sc.]' => Yii::t('app', 'Scottish English'),
            '[Austr.]' => Yii::t('app', 'Australian English'),
            '[Süddt.]' => Yii::t('app', 'Southern German'),
            '[Ös.]' => Yii::t('app', 'Austrian German'),
            '[Schw.]' => Yii::t('app', 'Swiss German'),
            '[ugs.]' => Yii::t('app', 'colloquial'),
            '[fig.]' => Yii::t('app', 'figurative'),
            '[übtr.]' => Yii::t('app', 'figurative'),
            '[slang]' => Yii::t('app', 'slang'),
            '[prov.]' => Yii::t('app', 'proverb'),
            '[Sprw.]' => Yii::t('app', 'proverb'),
            '[tm]' => Yii::t('app', 'trademark'),
        );
    }

    public static function defaultBranchNames() {
        return array(
            '[anat.]' => Yii::t('app', 'anatomy'),
            '[arch.]' => Yii::t('app', 'architecture'),
            '[astron.]' => Yii::t('app', 'astronomy'),
            '[auto]' => Yii::t('app', 'cars; automotive industry'),
            '[biochem.]' => Yii::t('app', 'biochemistry'),
            '[biol.]' => Yii::t('app', 'biology'),
            '[bot.]' => Yii::t('app', 'botany; plants'),
            '[chem.]' => Yii::t('app', 'chemistry'),
            '[comp.]' => Yii::t('app', 'computer'),
            '[constr.]' => Yii::t('app', 'construction'),
            '[econ.]' => Yii::t('app', 'economy'),
            '[electr.]' => Yii::t('app', 'electrical engineering, electronics'),
            '[cook.]' => Yii::t('app', 'dishes; cooking; eating; gastronomy'),
            '[geogr.]' => Yii::t('app', 'geography'),
            '[geol.]' => Yii::t('app', 'geology'),
            '[gramm.]' => Yii::t('app', 'grammar'),
            '[jur.]' => Yii::t('app', 'law'),
            '[math.]' => Yii::t('app', 'mathematics'),
            '[med.]' => Yii::t('app', 'medicine'),
            '[mil.]' => Yii::t('app', 'military'),
            '[min.]' => Yii::t('app', 'mineralogy'),
            '[mus.]' => Yii::t('app', 'music'),
            '[naut.]' => Yii::t('app', 'nautical science; seafaring'),
            '[ornith.]' => Yii::t('app', 'ornithology'),
            '[pharm.]' => Yii::t('app', 'pharmacology'),
            '[phil.]' => Yii::t('app', 'philosophy'),
            '[phys.]' => Yii::t('app', 'physics'),
            '[pol.]' => Yii::t('app', 'politics'),
            '[relig.]' => Yii::t('app', 'religion'),
            '[sport]' => Yii::t('app', 'sports'),
            '[techn.]' => Yii::t('app', 'technology; engineering'),
            '[textil.]' => Yii::t('app', 'textile industry'),
            '[zool.]' => Yii::t('app', 'zoology; animals'),
        );
    }

    public static function defaultPartOfSpeeches() {
        return array(
            '{m}' => Yii::t('app', 'noun, masculine'),
            '{f}' => Yii::t('app', 'noun, feminine'),
            '{n}' => Yii::t('app', 'noun, neuter'),
            '{pl}' => Yii::t('app', 'noun, plural'),
            '{vt}' => Yii::t('app', 'verb, transitive'),
            '{vi}' => Yii::t('app', 'verb, intransitive'),
            '{vr}' => Yii::t('app', 'verb, reflexive'),
            '{adj}' => Yii::t('app', 'adjective'),
            '{adv}' => Yii::t('app', 'adverb'),
            '{prp}' => Yii::t('app', 'preposition'),
            '{num}' => Yii::t('app', 'numeral'),
            '{art}' => Yii::t('app', 'article'),
            '{ppron}' => Yii::t('app', 'personal pronoun'),
            '{conj}' => Yii::t('app', 'conjunction'),
            '{interj}' => Yii::t('app', 'interjection'),
        );
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public static function getLabel() {
        return Yii::t('app', 'Shortcut');
    }

}
