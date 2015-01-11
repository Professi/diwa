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

namespace app\assets;

use yii\widgets\ActiveForm;

/**
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class AppAssetTemplate {

    private static $instance = null;
    private $errorCssClass = 'error';
    private $formTemplate = '<div class="row collapse"><div class="small-4 columns"><span class="prefix">{label}</div><div class="small-8 columns mobile-input">{input}<div>{error}</div></div></div>';
    private $formClass = 'small-12 columns small-centered';
    private $formTextAreaTemplate = '<div class="row collapse"><div class="small-12 columns" style="padding-left:.2em;">{input}{error}</div></div>';

    protected function __construct() {
        
    }

    protected function setFormClass($class) {
        $this->formClass = $class;
    }

    public static function getInstance() {
        if (AppAssetTemplate::$instance == null) {
            AppAssetTemplate::$instance = new AppAssetTemplate();
        }
        return AppAssetTemplate::$instance;
    }

    public function getFormClass() {
        return $this->formClass;
    }

    public function getFooterMenu() {
        return [
            ['label' => \Yii::t('app', 'Help'), 'url' => ['/site/help']],
            ['label' => \Yii::t('app', 'Imprint'), 'url' => ['/site/imprint']],
            ['label' => \Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
            ['label' => \Yii::t('app', 'Statistics'), 'url' => ['/statistic/statistics'], 'visible' => \Yii::$app->user->isAdmin() || \Yii::$app->user->isTerminologist()]
        ];
    }

    public function getDefaultActiveForm($additional = array()) {
        $options = [
            'options' => ['class' => $this->getFormClass()],
            'errorCssClass' => $this->getErrorCssClass(),
            'fieldConfig' => [
                'template' => $this->getFormTemplate(),
        ]];
        if (is_array($additional)) {
            $options = array_merge($options, $additional);
        }
        return ActiveForm::begin($options);
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

    protected function setFormTextAreaTemplate($template) {
        $this->formTextAreaTemplate = $template;
    }

    public function getFormTextAreaTemplate() {
        return $this->formTextAreaTemplate;
    }

}
