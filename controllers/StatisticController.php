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

use yii\filters\AccessControl;
use app\models\SearchRequest;
use yii\db\Query;

/**
 * Description of StatisticController
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class StatisticController extends \app\components\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->getAdvancedUserRoles(),
                    ]
                ],
            ],
        ];
    }

    public function actionStatistics() {
        return $this->render('statistics', $this->statistics());
    }

    private function statistics() {
        $months = [];
        $monthLabels = [];
        $current = new \DateTime('now');
        $request = new \DateTime($this->getFirstMonth()->requestTime);
        $month = $request->format('m');
        $year = $request->format('Y');
        $request->setTime(0, 0, 0);
        $request->setDate($year, $month, 1);
        $q = $this->monthCounterQuery();
        while ($request < $current) {
            $endRequest = clone $request;
            $endRequest->add(new \DateInterval('P1M'));
            $q->params([':start' => $request->format($this->getDbDateFormat()), ':end' => $endRequest->format($this->getDbDateFormat())]);
            $months[] = (int) $q->one()['c'];
            $monthLabels[] = $request->format("M-Y");
            $request->add(new \DateInterval('P1M'));
        }
        return ['totalRequests' => (int) SearchRequest::find()->count(),
            'monthLabels' => $monthLabels, 'months' => $months,
            'mostCommon' => $this->getMostCommonTerms()];
    }

    private function getMostCommonTerms() {
        return SearchRequest::find()->select(['request', 'COUNT(*) as c'])
                        ->groupBy('request')->orderBy('c DESC')
                        ->asArray()->limit(20)->all();
    }

    private function getDbDateFormat() {
        return 'Y-m-d H:i:s';
    }

    private function getFirstMonth() {
        return SearchRequest::find()->orderBy(['id' => 'ASC'])->one();
    }

    private function monthCounterQuery() {
        $q = new Query();
        $q->select('COUNT(*) AS c');
        $q->from(SearchRequest::tableName());
        $q->where('requestTime between DATE(:start) and (:end)');
        return $q;
    }

}