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

/**
 * Description of WebUser
 *
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class WebUser extends \yii\web\User{
   
    
//     /**
//     * Überschreibt eine Yii Methode, welche für die Zugriffsberechtigung
//     *  in Controllern verwendet wird (accessRules)
//     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
//     * @param string $role RollenID
//     * @param mixed $params (opt) Muss gesetzt werden durch Vererbung
//     * @return bool Permission granted?
//     */
//    public function checkAccess($role, $params = array()) {
//        if (empty($this->id)) {
//            return false;
//        }
//        if ($this->getState('role') == ADMIN) {
//            return true;
//        }
//        return ($role === $this->getState('role'));
//    }
//
//    /**
//     * Prüft ob ein User eine der beiden Rollen hat
//     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
//     * @param integer $role1 Benötigte Rolle
//     * @param integer $role2 Benötigte Rolle
//     * @return boolean Falls eine Operation mit der UserRolle übereinstimmt gibts true
//     */
//    public function checkAccessRole($role1, $role2) {
//        if (empty($this->id)) {
//            return false;
//        }
//        return ($role1 === $this->getState('role') || $role2 === $this->getState('role'));
//    }
//
//    /**
//     * Prüft ob ein Benutzer der Rolle zugewiesen wurde und ob er nicht Admin ist
//     * @param integer $role Rolle die der Benutzer haben sollte
//     * @return boolean
//     */
//    public function checkAccessNotAdmin($role) {
//        $rc = false;
//        if ($this->checkAccess($role) && !$this->isAdmin()) {
//            $rc = true;
//        }
//        return $rc;
//    }
//
//    /**
//     * ist der Benutzer ein Administrator?
//     * @author Christian Ehringfeld <c.ehringfeld@t-online,de>
//     * @return boolean selbsterklärend
//     */
//    public function isAdmin() {
//        return $this->checkRole(ADMIN);
//    }
//
//    /**
//     * Methode fuer isGuest
//     * @return boolean 
//     */
//    public function isGuest() {
//        return $this->isGuest;
//    }
//
//    private function checkRole($roleId) {
//        if (!empty($this->id) && $this->getState('role') == $roleId) {
//            return true;
//        }
//        return false;
//    }
//
//
//    private function setDynamicSessionVariables($state, $role, $groups = array()) {
//        $this->setState('state', $state);
//        $this->setState('role', $role);
//    }

    
    
    
}
