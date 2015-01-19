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

    protected function __construct() {
        
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

}
