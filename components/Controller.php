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
use app\models\enums\Role;
use yii\web\NotFoundHttpException;

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
    private $menu;
    private $errorCssClass = 'error';
    private $formTemplate = '<div class="row collapse"><div class="small-4 columns"><span class="prefix">{label}</div><div class="small-8 columns mobile-input">{input}<div>{error}</div></div></div>';
    private $formClass = 'small-12 columns small-centered';
    private $formTextAreaTemplate = '<div class="row collapse"><div class="small-12 columns" style="padding-left:.2em;">{input}{error}</div></div>';
    public $breadcrumbs = array();
    public $assetsDir;

    public function init() {
        $this->menu = Menu::getInstance();
        parent::init();
    }

    public function beforeAction($action) {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        $session->set('lastAction', $action->actionMethod);
        return parent::beforeAction($action);
    }

    protected function setFormTextAreaTemplate($template) {
        $this->formTextAreaTemplate = $template;
    }

    public function getFormTextAreaTemplate() {
        return $this->formTextAreaTemplate;
    }

    protected function setMenu($menu) {
        $this->menu = menu;
    }

    public function getMenu() {
        return $this->menu;
    }

    protected function setFormClass($class) {
        $this->formClass = $class;
    }

    public function getFormClass() {
        return $this->formClass;
    }

    protected function setErrorCssClass($class) {
        $this->errorCssClass = $class;
    }

    public function getErrorCssClass() {
        return $this->errorCssClass;
    }

    protected function setFormTemplate($template) {
        $this->formTemplate = $template;
    }

    public function getFormTemplate() {
        return $this->formTemplate;
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
