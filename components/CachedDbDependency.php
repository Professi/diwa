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

namespace app\components;

use yii\di\Instance;
use yii\base\InvalidConfigException;
use yii\db\Connection;

/**
 * Description of CachedDbDependency
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class CachedDbDependency extends \yii\caching\DbDependency {

    public $duration = 600;

    protected function generateDependencyData($cache) {
        $db = Instance::ensure($this->db, Connection::className());
        if ($this->sql === null) {
            throw new InvalidConfigException("DbDependency::sql must be set.");
        }
        if ($db->enableQueryCache) {
            // temporarily disable and re-enable query caching
            $db->enableQueryCache = false;
            $result = $this->getResult($db, $cache);
            $db->enableQueryCache = true;
        } else {
            $result = $this->getResult($db, $cache);
        }
        return $result;
    }

    protected function getResult($db, &$cache) {
        $command = $db->createCommand($this->sql, $this->params);
        if ($cache != null) {
            $key = md5($command->rawSql ^ '1');
            $data = $cache->get($key);
            if ($data === false) {
                $data = $command->queryOne();
                $cache->set($key, $data, $this->duration);
            }
            return $data;
        } else {
            return $command->queryOne();
        }
    }

}
