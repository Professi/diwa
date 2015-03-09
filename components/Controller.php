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
use app\models\enums\Role;
use yii\web\NotFoundHttpException;

/**
 * Description of Controller
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Controller extends \yii\web\Controller {

    private $menu;
    public $breadcrumbs = array();
    public $assetsDir;
    private $appAssetTemplate;

    public function init() {
        $this->instantiateViewVariables();
        parent::init();
    }

    public function instantiateViewVariables() {
        $this->menu = \app\components\Menu::getInstance();
        $this->appAssetTemplate = \app\assets\AppAssetTemplate::getInstance();
    }

    public function afterAction($action, $result) {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        if (!($action->controller instanceof \app\controllers\SearchController &&
                $action->actionMethod == 'actionSearch') && $session->has('search')) {
            $session->remove('search');
        }
        return parent::afterAction($action, $result);
    }

    protected function setMenu($menu) {
        $this->menu = $menu;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getAssetTemplate() {
        return $this->appAssetTemplate;
    }

    /**
     * @throws CHttpException 403
     */
    public function throwAccessDenied() {
        throw new \yii\web\HttpException(403, Yii::t('app', 'Access denied.'));
    }

    /**
     * @throws CHttpException 404
     */
    public function throwPageNotFound() {
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @throws CHttpException 400
     */
    public function throwInvalidRequest() {
        throw new \yii\web\HttpException(400, Yii::t('app', 'Invalid request.'));
    }

    public static function getYesOrNo() {
        return array('1' => Yii::t('app', 'Yes'), '0' => Yii::t('app', 'No'));
    }

    public function getAdvancedUserRoles() {
        return [Role::ADMIN, Role::TERMINOLOGIST];
    }

}
