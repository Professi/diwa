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

/**
 * Description of Controller
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Controller extends \yii\web\Controller {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $assetsDir;

    /**
     * @throws CHttpException 403
     */
    public function throwAccessDenied() {
        throw new \yii\web\HttpException(403, Yii::t('app', 'Zugriff verweigert.'));
    }

    /**
     * @throws CHttpException 404
     */
    public function throwPageNotFound() {
        throw new \yii\web\HttpException(404, Yii::t('app', 'Die angeforderte Seite konnte nicht gefunden werden.'));
    }

    /**
     * @throws CHttpException 400
     */
    public function throwInvalidRequest() {
        throw new \yii\web\HttpException(400, Yii::t('app', 'Ihre Anfrage ist ungültig.'));
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
            $link = '<li>' . CHtml::link("<i class={$icon}></i>{$labelTag}", $url) . '</li>';
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

    /**
     * sets Page Title with app->name and $name
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $name
     */
    public function setPageTitle($name) {
        parent::setPageTitle(Yii::$app()->name . ' - ' . $name);
    }

    public static function getYesOrNo() {
        return array('1' => Yii::t('app', 'Ja'), '0' => Yii::t('app', 'Nein'));
    }

}
