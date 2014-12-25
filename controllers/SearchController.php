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

namespace app\controllers;

use Yii;
use app\models\SearchRequest;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use app\models\Dictionary;
use app\components\Translator;
use yii\filters\AccessControl;

/**
 * SearchRequestController implements the CRUD actions for SearchRequest model.
 */
class SearchController extends \app\components\Controller {

    public $dataProvider = null;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['search'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => $this->getAdvancedUserRoles(),
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionSearch() {
        $model = new \app\models\forms\SearchForm();
        $partial = '';
        $dataProvider = null;
        $session = \Yii::$app->session;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $r = SearchRequest::createRequest($model->searchMethod, $model->dictionary, $model->searchWord);
            $r->save();
            $translator = new Translator();
            $dataProvider = $translator->translateRequest($r);
            $session['search'] = [
                'searchMethod' => $model->searchMethod,
                'dictionary' => $model->dictionary,
                'searchWord' => $model->searchWord,
            ];
        }
        if (($session->has('lastAction') && $session->get('lastAction') == 'actionSearch' && $session->has('search'))) {
            $model->searchMethod = $session['search']['searchMethod'];
            $model->searchWord = $session['search']['searchWord'];
            $model->dictionary = $session['search']['dictionary'];
            if (empty($dataProvider)) {
                $translator = new Translator();
                $dataProvider = $translator->translate($model->searchMethod, $model->searchWord, $model->dictionary);
            }
            $partial = $this->renderPartial('searchResult', ['dataProvider' => $dataProvider,
                'dict' => Dictionary::find()->where('id=:dictId')->params([':dictId' => $model->dictionary])->one()]
            );
        } else {
            if ($session->has('search')) {
                $session->remove('search');
            }
        }
        return $this->render('search', [
                    'model' => $model,
                    'partial' => $partial,
        ]);
    }

    public function getDictionaries() {
        $dicts = \app\models\Dictionary::find()->all();
        $r = array();
        foreach ($dicts as $val) {
            $r[$val->getPrimaryKey()] = $val->getLanguage1()->shortname . "<->" . $val->getLanguage2()->shortname;
        }
        return $r;
    }

    /**
     * Lists all SearchRequest models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => SearchRequest::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SearchRequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the SearchRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SearchRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SearchRequest::findOne($id)) !== null) {
            return $model;
        } else {
            $this->throwPageNotFound();
        }
    }

}
