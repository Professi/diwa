<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

//        $cs = Yii::app()->getClientScript();
//
//        $cs->registerCssFile($this->assetsDir . '/css/app.css');
//        //  $cs->registerCssFile($this->assetsDir . '/css/print.min.css', 'print');
//
//        if (Yii::app()->user->checkAccess(ADMIN)) {
//            $cs->registerCssFile($this->assetsDir . "/css/select2.min.css");
//        }
//
//        $cs->scriptMap['jquery.js'] = $this->assetsDir . '/js/jquery.js';
//        $cs->scriptMap['jquery.min.js'] = $this->assetsDir . '/js/jquery.min.js';
//        $cs->scriptMap['jquery-ui.js'] = $this->assetsDir . '/js/jquery-ui.js';
//        $cs->scriptMap['jquery-ui.min.js'] = $this->assetsDir . '/js/jquery-ui.min.js';
//
//        $cs->registerCoreScript('jquery.js');
//
//        $cs->registerScriptFile($this->assetsDir . '/js/fastclick.js', CClientScript::POS_END);
//        $cs->registerScriptFile($this->assetsDir . '/js/modernizr.js', CClientScript::POS_END);
//        $cs->registerScriptFile($this->assetsDir . '/js/placeholder.js', CClientScript::POS_END);
//        $cs->registerScriptFile($this->assetsDir . '/js/foundation.min.js', CClientScript::POS_END);
//
//        if (YII_DEBUG) {
//            $cs->registerScriptFile($this->assetsDir . '/js/app.js', CClientScript::POS_END);
//        } else {
//            $cs->registerScriptFile($this->assetsDir . '/js/app.min.js', CClientScript::POS_END);
//        }