<?php

use yii\db\Schema;
use yii\db\Migration;

class m141201_200912_schema extends Migration {

    public function up() {
        $this->createTable('user', array(
            'id' => 'pk',
            'username' => 'string',
            'password' => 'string',
            'authKey' => 'string',
            'role' => 'smallint',
            'lastLogin' => 'date',
        ));
        $this->createTable('language', array(
            'id' => 'pk',
            'shortname' => 'string',
            'name' => 'string',
        ));
        $this->createTable('partofspeech', array(
            'id' => 'pk',
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

        $this->createIndex('idx_username1', 'user', ['username'], true);
        $this->createIndex('idx_language1', 'language', ['shortname', 'name'], true);
        $this->createIndex('idx_unknownword1', 'unknownword', ['name', 'dictionary_id'], true);
        $this->addForeignKey('fk_unknownword_dictionary_id', 'unknownword', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_dictionary_language1_id', 'dictionary', 'language1_id', 'language', 'id');
        $this->addForeignKey('fk_dictionary_language2_id', 'dictionary', 'language2_id', 'language', 'id');
        $this->addForeignKey('fk_translation_dictionary_id', 'translation', 'dictionary_id', 'dictionary', 'id');
        $this->addForeignKey('fk_translation_partofspeech_id', 'translation', 'partofspeech_id', 'partofspeech', 'id');
    }

    public function down() {
        $this->dropForeignKey('fk_translation_partofspeech_id', 'translation');
        $this->dropForeignKey('fk_translation_dictionary_id', 'translation');
        $this->dropForeignKey('fk_dictionary_language2_id', 'dictionary');
        $this->dropForeignKey('fk_dictionary_language1_id', 'dictionary');
        $this->dropForeignKey('fk_unknownword_dictionary_id', 'unknownword');
        $this->dropIndex('idx_unknownword1', 'unknownword');
        $this->dropIndex('idx_language1', 'language');
        $this->dropIndex('idx_username1', 'user');
        $this->dropTable('translation');
        $this->dropTable('dictionary');
        $this->dropTable('unknownword');
        $this->dropTable('partofspeech');
        $this->dropTable('language');
        $this->dropTable('user');
    }

}
