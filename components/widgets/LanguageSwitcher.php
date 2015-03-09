<?php

/**
 * @see https://github.com/makroxyz/yii2-language-selector
 * @license https://github.com/makroxyz/yii2-language-selector/blob/master/LICENSE The MIT License (MIT)
 * @author Marco Curatitoli
 * edited by Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */

namespace app\components\widgets;

use Yii;
use yii\base\Component;
use yii\helpers\Url;

class LanguageSwitcher extends Component {

    /**
     * @var string query param name 
     */
    public $queryParam = 'lang';

    public function init() {
        parent::init();
        if (!isset(Yii::$app->params['languages'])) {
            throw new \yii\base\InvalidConfigException("You must define Yii::\$app->params['languages'] array");
        }
        $request = Yii::$app->getRequest();
        $lang = $request->get($this->queryParam);
        if ($lang !== null) {
            Yii::$app->session->set($this->getKey(), $lang);
            Yii::$app->language = $lang;
        } else if (Yii::$app->session->get($this->getKey()) === null) {
            $preferredLang = $request->getPreferredLanguage(array_keys(Yii::$app->params['languages']));
            if ($preferredLang !== null) {
                Yii::$app->session->set($this->getKey(), $preferredLang);
                Yii::$app->language = $preferredLang;
            } else {
                Yii::$app->session->set($this->getKey(), Yii::$app->language);
            }
        } else {
            Yii::$app->language = Yii::$app->session->get($this->getKey());
        }
    }

    public function getKey() {
        return 'language.' . $this->queryParam;
    }

    protected function url($lang) {
        $resolve = Yii::$app->request->resolve();
        $route = "/" . $resolve[0];
        $params = $resolve[1];
        $params['lang'] = $lang;
        return array_merge([$route], $params);
    }

    public function getMenuItems() {
        $items = [];
        foreach (Yii::$app->params['languages'] as $lang => $desc) {
            $items[] = [
                'label' => $desc,
                'url' => $this->url($lang),
                'active' => !(Yii::$app->session->get($this->key) == $lang),
            ];
        }
        return $items;
    }

}
