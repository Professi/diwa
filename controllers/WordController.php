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
use app\models\Word;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\Controller;

/**
 * WordController implements the CRUD actions for Word model.
 */
class WordController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['get-words'],
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
     * Creates a new Word model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Word();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionGetWords($term, $dict, $regex = true) {
        \Yii::$app->response->format = 'json';
        $wordArr = [];
        if (is_string($term) && is_numeric($dict)) {
            $dictObj = \app\models\Dictionary::find()->where('id=:dictId')->params([':dictId' => $dict])->one();
            $words = Word::find()->where('(language_id=:lang1Id OR language_id=:lang2Id) AND word LIKE :word')
                            ->params([':word' => $term . '%', ':lang1Id' => $dictObj->language1_id, ':lang2Id' => $dictObj->language2_id,])
                            ->select(['word'])->limit(10)->asArray()->all();
            if ($regex) {
                foreach ($words as $wordObj) {
                    $wordArr[] = trim(preg_replace(["&{.*}&is", "&\[.*\]&is"], '', $wordObj['word']));
                }
            } else {
                               foreach ($words as $wordObj) {
                    $wordArr[] = trim($wordObj['word']);
                }
            }
        }
        return array_unique($wordArr);
    }

    /**
     * Lists all Word models.
     * @return mixed
     */
    public function actionIndex() {
        $filterModel = new \app\models\search\WordSearch();
        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'filterModel' => $filterModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Word model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Word the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Word::findOne($id)) !== null) {
            return $model;
        } else {
            $this->throwPageNotFound();
        }
    }

    /**
     * Deletes an existing Word model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Word model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Word model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

}
