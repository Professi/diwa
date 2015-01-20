<?php

use yii\db\Migration;
use yii\db\Schema;

class m141201_200912_schema extends Migration {

    public function safeUp() {
        $this->createTable(\app\models\User::tableName(), array(
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING,
            'password' => Schema::TYPE_STRING,
            'authKey' => Schema::TYPE_STRING,
            'role' => Schema::TYPE_SMALLINT,
            'lastLogin' => Schema::TYPE_TIMESTAMP,
        ));
        $this->createTable(\app\models\Language::tableName(), array(
            'id' => Schema::TYPE_PK,
            'shortname' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
        ));
        $this->createTable(\app\models\UnknownWord::tableName(), array(
            'id' => Schema::TYPE_PK,
            'searchRequest_id' => Schema::TYPE_BIGINT,
        ));
        $this->createTable(\app\models\Dictionary::tableName(), array(
            'id' => Schema::TYPE_PK,
            'language1_id' => Schema::TYPE_INTEGER,
            'language2_id' => Schema::TYPE_INTEGER,
        ));
        $this->createTable(\app\models\Translation::tableName(), array(
            'id' => Schema::TYPE_BIGPK,
            'dictionary_id' => Schema::TYPE_INTEGER,
            'word1_id' => Schema::TYPE_BIGINT,
            'word2_id' => Schema::TYPE_BIGINT,
        ));
        $this->createTable(\app\models\SearchRequest::tableName(), array(
            'id' => Schema::TYPE_BIGPK,
            'dictionary_id' => Schema::TYPE_INTEGER,
            'searchMethod' => Schema::TYPE_INTEGER,
            'request' => Schema::TYPE_STRING,
            'ipAddr' => Schema::TYPE_STRING,
            'useragent_id' => Schema::TYPE_INTEGER,
            'requestTime' => Schema::TYPE_TIMESTAMP,
        ));
        $this->createTable(app\models\UserAgent::tableName(), array(
            'id' => Schema::TYPE_PK,
            'agent' => Schema::TYPE_TEXT,
            'agentHash' => Schema::TYPE_STRING
        ));
        $this->createTable(\app\models\Word::tableName(), array(
            'id' => Schema::TYPE_BIGPK,
            'language_id' => Schema::TYPE_INTEGER,
            'word' => Schema::TYPE_TEXT,
        ));
        $this->createTable('session', array(
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => Schema::TYPE_INTEGER,
            'data' => \yii\db\Schema::TYPE_BINARY,
        ));

        $this->createTable(app\models\Shortcut::tableName(), array(
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
        $this->createIndex('idx_shortcut1', \app\models\Shortcut::tableName(), ['shortcut'], true);
        $this->createIndex('idx_username1', \app\models\User::tableName(), ['username'], true);
        $this->createIndex('idx_user_authKey', \app\models\User::tableName(), ['authKey'], true);
        $this->createIndex('idx_language1', \app\models\Language::tableName(), ['shortname', 'name'], true);
        $this->createIndex('idx_unknownword1', \app\models\UnknownWord::tableName(), ['searchRequest_id'], true);
        $this->createIndex('idx_useragent_agentHash1', \app\models\UserAgent::tableName(), ['agentHash'], true);
        $this->addForeignKey('fk_unknownword_searchRequest_id', \app\models\UnknownWord::tableName(), 'searchRequest_id', 'searchrequest', 'id');
        $this->addForeignKey('fk_dictionary_language1_id', \app\models\Dictionary::tableName(), 'language1_id', 'language', 'id');
        $this->addForeignKey('fk_dictionary_language2_id', \app\models\Dictionary::tableName(), 'language2_id', 'language', 'id');
        $this->addForeignKey('fk_word_language_id', \app\models\Word::tableName(), 'language_id', 'language', 'id');
        $this->addForeignKey('fk_translation_dictionary_id', \app\models\Translation::tableName(), 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_translation_word1_id', \app\models\Translation::tableName(), 'word1_id', 'word', 'id');
        $this->addForeignKey('fk_translation_word2_id', \app\models\Translation::tableName(), 'word2_id', 'word', 'id');
        $this->addForeignKey('fk_searchrequest_dictionary_id', \app\models\SearchRequest::tableName(), 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_searchrequest_useragent_id', \app\models\SearchRequest::tableName(), 'useragent_id', 'useragent', 'id');
        $user = new app\models\User();
        $user->username = 'admin';
        $user->password = 'admin';
        $user->role = \app\models\enums\Role::ADMIN;
        $user->save();
        \app\models\Shortcut::defaultShortcuts();
    }

    public function safeDown() {
        $this->dropForeignKey('fk_translation_word1_id', \app\models\Translation::tableName());
        $this->dropForeignKey('fk_translation_word2_id', \app\models\Translation::tableName());
        $this->dropForeignKey('fk_searchrequest_useragent_id', \app\models\SearchRequest::tableName());
        $this->dropForeignKey('fk_searchrequest_dictionary_id', \app\models\SearchRequest::tableName());
        $this->dropForeignKey('fk_translation_dictionary_id', \app\models\Translation::tableName());
        $this->dropForeignKey('fk_dictionary_language2_id', \app\models\Dictionary::tableName());
        $this->dropForeignKey('fk_dictionary_language1_id', \app\models\Dictionary::tableName());
        $this->dropForeignKey('fk_unknownword_searchRequest_id', \app\models\UnknownWord::tableName());
        $this->dropForeignKey('fk_word_language_id', \app\models\Word::tableName());
        $this->dropIndex('idx_user_authKey', \app\models\User::tableName());
        $this->dropIndex('ft_idx_word1', \app\models\Word::tableName());
        $this->dropIndex('idx_useragent_agentHash1', \app\models\UserAgent::tableName());
        $this->dropIndex('idx_unknownword1', \app\models\UnknownWord::tableName());
        $this->dropIndex('idx_language1', \app\models\Language::tableName());
        $this->dropIndex('idx_username1', \app\models\User::tableName());
        $this->dropIndex('idx_shortcut1', \app\models\Shortcut::tableName());
        $this->dropTable(\app\models\Shortcut::tableName());
        $this->dropTable('session');
        $this->dropTable(\app\models\SearchRequest::tableName());
        $this->dropTable(\app\models\UserAgent::tableName());
        $this->dropTable(\app\models\Translation::tableName());
        $this->dropTable(\app\models\Dictionary::tableName());
        $this->dropTable(\app\models\UnknownWord::tableName());
        $this->dropTable(\app\models\Language::tableName());
        $this->dropTable(\app\models\Word::tableName());
        $this->dropTable(\app\models\User::tableName());
    }

}
