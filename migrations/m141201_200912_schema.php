<?php

use yii\db\Migration;

class m141201_200912_schema extends Migration {

    public function up() {
        $this->createTable('user', array(
            'id' => 'pk',
            'username' => 'string',
            'password' => 'string',
            'authKey' => 'string',
            'role' => 'smallint',
            'lastLogin' => 'timestamp',
        ));
        $this->createTable('language', array(
            'id' => 'pk',
            'shortname' => 'string',
            'name' => 'string',
        ));
        $this->createTable('unknownword', array(
            'id' => 'pk',
            'name' => 'string',
            'dictionary_id' => 'integer',
        ));
        $this->createTable('dictionary', array(
            'id' => 'pk',
            'language1_id' => 'integer',
            'language2_id' => 'integer',
        ));
        $this->createTable('translation', array(
            'id' => 'bigpk',
            'dictionary_id' => 'integer',
            'word1' => 'text',
            'word2' => 'text',
            'partofspeech_id' => 'integer',
        ));
        $this->createTable('searchrequest', array(
            'id' => 'bigpk',
            'dictionary_id' => 'integer',
            'request' => 'string',
            'ipAddr' => 'string',
            'useragent_id' => 'integer',
            'requestTime' => 'datetime',
        ));
        $this->createTable('useragent', array(
            'id' => 'pk',
            'agent' => 'text',
            'agentHash' => 'string'
        ));
        $this->createTable('session', array(
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'integer',
            'data' => 'blob',
        ));
        $this->createIndex('idx_username1', 'user', ['username'], true);
        $this->createIndex('idx_language1', 'language', ['shortname', 'name'], true);
        $this->createIndex('idx_unknownword1', 'unknownword', ['name', 'dictionary_id'], true);
        $this->createIndex('idx_useragent_agentHash1', 'useragent', ['agentHash'], true);
        $this->addForeignKey('fk_unknownword_dictionary_id', 'unknownword', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_dictionary_language1_id', 'dictionary', 'language1_id', 'language', 'id');
        $this->addForeignKey('fk_dictionary_language2_id', 'dictionary', 'language2_id', 'language', 'id');
        $this->addForeignKey('fk_translation_dictionary_id', 'translation', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_searchrequest_dictionary_id', 'searchrequest', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_searchrequest_useragent_id', 'searchrequest', 'useragent_id', 'useragent', 'id');
        $user = new app\models\User();
        $user->username = 'admin';
        $user->password = 'admin';
        $user->role = \app\models\enums\Role::ADMIN;
        $user->lastLogin = 0;
        $user->save();
    }

    public function down() {
        $this->dropForeignKey('fk_searchrequest_useragent_id', 'searchrequest');
        $this->dropForeignKey('fk_searchrequest_dictionary_id', 'searchrequest');
        $this->dropForeignKey('fk_translation_dictionary_id', 'translation');
        $this->dropForeignKey('fk_dictionary_language2_id', 'dictionary');
        $this->dropForeignKey('fk_dictionary_language1_id', 'dictionary');
        $this->dropForeignKey('fk_unknownword_dictionary_id', 'unknownword');
        $this->dropIndex('idx_useragent_agentHash1', 'useragent');
        $this->dropIndex('idx_unknownword1', 'unknownword');
        $this->dropIndex('idx_language1', 'language');
        $this->dropIndex('idx_username1', 'user');
        $this->dropTable('session');
        $this->dropTable('searchrequest');
        $this->dropTable('useragent');
        $this->dropTable('translation');
        $this->dropTable('dictionary');
        $this->dropTable('unknownword');
        $this->dropTable('language');
        $this->dropTable('user');
    }

}
