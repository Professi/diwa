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

namespace app\components;

use Yii;
use yii\helpers\Html;

/**
 * Description of Menu
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Menu {

    private static $instance = null;
    private $menu;

    private function __construct() {
        $this->menu = [//icon,label,url,visible(bool)
            ['fi-list', \Yii::t('app', 'Search'), ['/search/search'], true],
            ['fi-power', \Yii::t('app', 'Login'), ['site/login'], Yii::$app->user->isGuest()],
            ['fi-flag', \Yii::t('app', 'Languages'), ['language/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-book', \Yii::t('app', 'Dictionaries'), ['dictionary/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-refresh', \Yii::t('app', 'Search requests'), ['search/index'], Yii::$app->user->isAdmin()],
            ['fi-comments', \Yii::t('app', 'Translations'), ['translation/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-list-bullet', \Yii::t('app', 'Words'), ['word/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-filter', \Yii::t('app', 'Unknown words'), ['unknown-word/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-monitor', \Yii::t('app', 'User Agents'), ['user-agent/index'], Yii::$app->user->isAdmin()],
            ['fi-comment-minus', \Yii::t('app', 'Shortcuts'), ['shortcut/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-quote', \Yii::t('app', 'Sources'), ['source/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-comment', \Yii::t('app', 'Additional informations'), ['additional-information/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-comment', \Yii::t('app', 'Categories'), ['ai-category/index'], Yii::$app->user->isAdvancedUser()],
            ['fi-torsos', \Yii::t('app', 'Users'), ['user/index'], Yii::$app->user->isAdmin()],
            ['fi-power', \Yii::t('app', 'Logout'), ['site/logout'], !Yii::$app->user->isGuest()],
        ];
    }

    public static function getInstance() {
        if (Menu::$instance === null) {
            Menu::$instance = new Menu();
        }
        return Menu::$instance;
    }

    public function getMenu() {
        return $this->menu;
    }

    /**
     * 
     * @param string $icon
     * @param string $label
     * @param string $url
     * @param bool $visible
     * @param bool $mobile
     * @author David Mock
     * @access public
     * @return string 
     */
    public function generateFoundation5MenuItem($icon, $label, $url, $visible, $mobile) {
        $link = '';
        $labelTag = ($mobile) ? $label : "<span>{$label}</span>";
        if ($visible) {
            $link = '<li>' . Html::a("<i class={$icon}></i>{$labelTag}", $url) . '</li>';
        }
        return $link;
    }

    /**
     * 
     * @param mixed $menuArray
     * @param bool $mobile
     * @author David Mock
     * @access public
     * @return string[]
     */
    public function generateFoundation5Menu($menuArray, $mobile) {
        $menu = '';
        for ($i = 0; $i < count($menuArray); $i++) {
            $menu .= $this->generateFoundation5MenuItem($menuArray[$i][0], $menuArray[$i][1], $menuArray[$i][2], $menuArray[$i][3], $mobile);
        }
        return $menu;
    }

    public function generate($mobile) {
        return $this->generateFoundation5Menu($this->menu, $mobile);
    }

}
