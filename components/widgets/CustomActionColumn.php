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

namespace app\components\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Description of CustomButtomColumn
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class CustomActionColumn extends \yii\grid\ActionColumn {

    public function init() {
        parent::init();
        $this->contentOptions['class'] = 'text-center';
    }

    protected function initDefaultButtons() {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<i class="fi-magnifying-glass"></i>', $url, [
                            'class' => 'table-button view',
                            'title' => Yii::t('app', 'View'),
                            'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('<i class="fi-pencil"></i>', $url, [
                            'class' => 'table-button update',
                            'title' => Yii::t('app', 'Update'),
                            'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<i class="fi-trash"></i>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'table-button delete',
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                ]);
            };
        }
    }

}
