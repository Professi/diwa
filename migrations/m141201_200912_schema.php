<?php

use yii\db\Migration;
use yii\db\Schema;

class m141201_200912_schema extends Migration {

    public function up() {
        $this->createTable('user', array(
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING,
            'password' => Schema::TYPE_STRING,
            'authKey' => Schema::TYPE_STRING,
            'role' => Schema::TYPE_SMALLINT,
            'lastLogin' => Schema::TYPE_TIMESTAMP,
        ));
        $this->createTable('language', array(
            'id' => Schema::TYPE_PK,
            'shortname' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
        ));
        $this->createTable('unknownword', array(
            'id' => Schema::TYPE_PK,
            'searchRequest_id' => Schema::TYPE_BIGINT,
        ));
        $this->createTable('dictionary', array(
            'id' => Schema::TYPE_PK,
            'language1_id' => Schema::TYPE_INTEGER,
            'language2_id' => Schema::TYPE_INTEGER,
        ));
        $this->createTable('translation', array(
            'id' => Schema::TYPE_BIGPK,
            'dictionary_id' => Schema::TYPE_INTEGER,
            'word1_id' => Schema::TYPE_BIGINT,
            'word2_id' => Schema::TYPE_BIGINT,
        ));
        $this->createTable('searchrequest', array(
            'id' => Schema::TYPE_BIGPK,
            'dictionary_id' => Schema::TYPE_INTEGER,
            'searchMethod' => Schema::TYPE_INTEGER,
            'request' => Schema::TYPE_STRING,
            'ipAddr' => Schema::TYPE_STRING,
            'useragent_id' => Schema::TYPE_INTEGER,
            'requestTime' => Schema::TYPE_TIMESTAMP,
        ));
        $this->createTable('useragent', array(
            'id' => Schema::TYPE_PK,
            'agent' => Schema::TYPE_TEXT,
            'agentHash' => Schema::TYPE_STRING
        ));
        $this->createTable('word', array(
            'id' => Schema::TYPE_BIGPK,
            'language_id' => Schema::TYPE_INTEGER,
            'word' => Schema::TYPE_STRING,
        ));
        $this->createTable('session', array(
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => \yii\db\Schema::TYPE_BINARY,
        ));

        $this->createTable('shortcut', array(
            'id' => Schema::TYPE_PK,
            'shortcut' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
            'kind' => Schema::TYPE_SMALLINT,
        ));
        if (\Yii::$app->db->getDriverName() == 'pgsql') {
            $this->execute('CREATE INDEX "ft_idx_word_simple" ON "word" USING gin(to_tsvector(\'simple\',"word"));');
        } else if (\Yii::$app->db->getDriverName() == 'mysql') {
            $this->execute('CREATE FULLTEXT INDEX ft_idx_word ON `word` (word);');
        }
        $this->createIndex('idx_shortcut1', 'shortcut', ['shortcut'], true);
        $this->createIndex('idx_username1', 'user', ['username'], true);
        $this->createIndex('idx_user_authKey', 'user', ['authKey'], true);
        $this->createIndex('idx_word1', 'word', ['word', 'language_id'], true);
        $this->createIndex('idx_language1', 'language', ['shortname', 'name'], true);
        $this->createIndex('idx_unknownword1', 'unknownword', ['searchRequest_id'], true);
        $this->createIndex('idx_useragent_agentHash1', 'useragent', ['agentHash'], true);
        $this->addForeignKey('fk_unknownword_searchRequest_id', 'unknownword', 'searchRequest_id', 'searchrequest', 'id');
        $this->addForeignKey('fk_dictionary_language1_id', 'dictionary', 'language1_id', 'language', 'id');
        $this->addForeignKey('fk_dictionary_language2_id', 'dictionary', 'language2_id', 'language', 'id');
        $this->addForeignKey('fk_word_language_id', 'word', 'language_id', 'language', 'id');
        $this->addForeignKey('fk_translation_dictionary_id', 'translation', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_translation_word1_id', 'translation', 'word1_id', 'word', 'id');
        $this->addForeignKey('fk_translation_word2_id', 'translation', 'word2_id', 'word', 'id');
        $this->addForeignKey('fk_searchrequest_dictionary_id', 'searchrequest', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_searchrequest_useragent_id', 'searchrequest', 'useragent_id', 'useragent', 'id');
        $user = new app\models\User();
        $user->username = 'admin';
        $user->password = 'admin';
        $user->role = \app\models\enums\Role::ADMIN;
//        $user->lastLogin = time();
        $user->save();
        \app\models\Shortcut::defaultShortcuts();
    }

    public function down() {
        $this->dropForeignKey('fk_translation_word1_id', 'translation');
        $this->dropForeignKey('fk_translation_word2_id', 'translation');
        $this->dropForeignKey('fk_searchrequest_useragent_id', 'searchrequest');
        $this->dropForeignKey('fk_searchrequest_dictionary_id', 'searchrequest');
        $this->dropForeignKey('fk_translation_dictionary_id', 'translation');
        $this->dropForeignKey('fk_dictionary_language2_id', 'dictionary');
        $this->dropForeignKey('fk_dictionary_language1_id', 'dictionary');
        $this->dropForeignKey('fk_unknownword_searchRequest_id', 'unknownword');
        $this->dropForeignKey('fk_word_language_id', 'word');
        $this->dropIndex('idx_user_authKey', 'user');
        $this->dropIndex('ft_idx_word1', 'word');
        $this->dropIndex('idx_useragent_agentHash1', 'useragent');
        $this->dropIndex('idx_unknownword1', 'unknownword');
        $this->dropIndex('idx_language1', 'language');
        $this->dropIndex('idx_username1', 'user');
        $this->dropIndex('idx_word1', 'word');
        $this->dropIndex('idx_shortcut1', 'shortcut');
        $this->dropTable('shortcut');
        $this->dropTable('session');
        $this->dropTable('searchrequest');
        $this->dropTable('useragent');
        $this->dropTable('translation');
        $this->dropTable('dictionary');
        $this->dropTable('unknownword');
        $this->dropTable('language');
        $this->dropTable('word');
        $this->dropTable('user');
    }

}
