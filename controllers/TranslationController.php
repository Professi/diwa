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
use app\models\Translation;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\SearchRequest;
use app\models\Dictionary;
use app\components\Translator;

/**
 * TranslationController implements the CRUD actions for Translation model.
 */
class TranslationController extends \app\components\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['search', 'view'],
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

    /**
     * Lists all Translation models.
     * @return mixed
     */
    public function actionIndex() {
        $filterModel = new \app\models\search\TranslationSearch();
        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'filterModel' => $filterModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Translation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Translation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new \app\models\forms\TranslationForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->additionalInformations = $this->explodeInformations();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->translation->getId()]);
            }
        }
        $model->additionalInformations = $this->selectAi($model);
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function getDictionaries() {
        $r = [];
        foreach (Dictionary::cachedDictionaries() as $val) {
            $r[$val->id] = $val->getLongname();
        }
        return $r;
    }

    public function actionSearch() {
        $model = new \app\models\forms\SearchForm();
        $partial = '';
        $dataProvider = null;
        $session = \Yii::$app->session;
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $translator = new Translator();
            if (!$session->has('search') || ($session->has('search') && $session->get('search') != $model->searchWord)) {
                $r = SearchRequest::createRequest($model->searchMethod, $model->dictionary, $model->searchWord);
                $r->save();
                $dataProvider = $translator->translateRequest($r);
                $session->set('search', $model->searchWord);
            } else {
                $dataProvider = $translator->translate($model->searchMethod, $model->searchWord, $model->dictionary);
            }
            if (!empty($dataProvider)) {
                $partial = $this->renderPartial('searchResult', [
                    'dataProvider' => $dataProvider,
                    'dict' => Dictionary::find()->where('id=:dictId')
                            ->params([':dictId' => $model->dictionary])->one()]
                );
            }
        }
        return $this->render('search', [
                    'model' => $model,
                    'partial' => $partial,
        ]);
    }

    public function highlightWord($src, $word) {
        $word = strtolower(trim($word));
        $r = str_replace($word, '<b>' . $word . '</b>', $src);
        $r = str_replace(ucfirst($word), '<b>' . ucfirst($word) . '</b>', $r);
        return $r;
    }

    /**
     * Updates an existing Translation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $modelObj = Translation::find()->where(['id' => $id])->with(['word1', 'word2'])->one();
        $model = new \app\models\forms\TranslationForm();
        $model->word1 = $modelObj->word1->word;
        $model->word2 = $modelObj->word2->word;
        $model->dictionary_id = $modelObj->dictionary->getId();
        $model->translationId = $modelObj->getId();
        $model->src_id = $modelObj->src_id;
        $model->translation = $modelObj;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->additionalInformations = $this->explodeInformations();
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->translation->getId()]);
            }
        }
        $model->additionalInformations = $this->selectAi($model);
        return $this->render('update', [
                    'model' => $model,
                    'create' => false,
        ]);
    }

    public function selectAi(&$model) {
        $arr = [];
        if ($model->translation) {
            foreach ($model->translation->getAiTranslations()->all() as $ai) {
                $arr[] = AdditionalInformationController::formatAiForJson($ai->getAdditionalInformation()->one());
            }
        }
        return empty($arr) ? '' : \yii\helpers\Json::encode($arr);
    }

    /**
     * Deletes an existing Translation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Translation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Translation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Translation::findOne($id)) !== null) {
            return $model;
        } else {
            $this->throwPageNotFound();
        }
    }

    protected function explodeInformations() {
        return explode(AdditionalInformationController::DELIMITER, Yii::$app->request->post()['TranslationForm']['additionalInformations']);
    }

}
