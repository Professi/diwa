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

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->css = [
            'css/foundation.css',
            YII_DEBUG ? 'css/app.css' : 'css/app.min.css',];
        $this->js = [
            YII_DEBUG ? 'js/jquery-ui.js' : 'js/jquery-ui.min.js',
            'js/fastclick.js',
            'js/modernizr.js',
            'js/placeholder.js',
            'js/foundation.min.js',
            YII_DEBUG ? 'js/app.js' : 'js/app.min.js'
        ];
    }

}
