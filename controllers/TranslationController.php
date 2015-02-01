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
            if ($model->create()) {
                return $this->redirect(['view', 'id' => $model->getTranslationId()]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
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
        $model->create = false;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->create()) {
                return $this->redirect(['view', 'id' => $model->getTranslationId()]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'create' => false,
            ]);
        }
    }

    public function actionGetInformations($term) {
        \Yii::$app->response->format = 'json';
        $return = [];
        $objects = [];
        if (!empty($term)) {
            if (is_numeric($term)) {
                $objects = \app\models\Additionalinformation::find()->where(['id' => $term])->asArray()->all();
            } else {
                $objects = \app\models\Additionalinformation::find()->where('text LIKE :text')->params([':text' => $term . '%'])->asArray()->all();
            }
            if (is_array($objects)) {
                foreach ($objects as $o) {
                    $return[] = ['id' => $o->getId(), 'text' => $o->getText()];
                }
            }
        }
        return $return;
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

}
