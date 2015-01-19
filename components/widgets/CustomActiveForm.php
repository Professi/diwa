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

/**
 * Description of CustomActiveForm
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class CustomActiveForm extends \yii\widgets\ActiveForm {

    public $formClass = 'small-12 columns small-centered';

    public function getLabelTemplate() {
        return '<div class="small-4 columns"><span class="prefix">{label}</span></div>';
    }

    public function getBeginFileInputTemplate() {
        return '<div class="small-4 columns"><div class="prefix button file-input"><i class="fi-upload"></i><span>&nbsp;' . Yii::t('app', 'Choose file') . '</span>{input}</div>';
    }

    public function getBeginDiv() {
        return '<div class="row collapse">';
    }

    public function getEndDiv() {
        return '</div>';
    }

    public function getBeginInputTemplate() {
        return '<div class="small-8 columns mobile-input">{input}';
    }

    public function getBeginTextAreaTemplate() {
        return '<div class="row collapse"><div class="small-12 columns" style="padding-left:.2em;">{input}';
    }

    public function getEndInputTemplate() {
        return '</div>';
    }

    public function getErrorTemplate() {
        return '<div>{error}</div>';
    }

    public function getReadonlyInputField() {
        return '<div class="small-4 columns"><input type="text" value="" name="" id="file-input-name" readonly="readonly"></div>';
    }

    public function getFileInputTemplate() {
        return $this->getBeginDiv() . $this->getLabelTemplate() . $this->getBeginFileInputTemplate() . $this->getErrorTemplate() . $this->getEndInputTemplate() . $this->getReadonlyInputField() . $this->getEndDiv();
    }

    public function getTextAreaTemplate() {
        return $this->getBeginDiv() . $this->getBeginTextAreaTemplate() . $this->getErrorTemplate() . $this->getEndInputTemplate() . $this->getEndDiv();
    }

    public function getInputTemplate() {
        return $this->getBeginDiv() . $this->getLabelTemplate() . $this->getBeginInputTemplate() . $this->getErrorTemplate() . $this->getEndInputTemplate() . $this->getEndDiv();
    }

    public function init() {
        $this->errorCssClass = 'error';
        $this->fieldConfig = [
            'template' => $this->getInputTemplate(),
        ];
        $this->options['class'] = $this->formClass;
        parent::init();
    }

}
