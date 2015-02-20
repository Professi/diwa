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
/**
 * Description of Selectize
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class Selectize extends \dosamigos\selectize\Selectize{
    public function init() {
        Selectize::$theme = \dosamigos\selectize\SelectizeLegacyAsset::class;
        parent::init();
    }
}
