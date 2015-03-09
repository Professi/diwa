<?php

use yii\db\Schema;
use yii\db\Migration;

class m150123_212547_create_additionalInformations_table extends Migration {

    public function safeUp() {
        $this->createTable('ai_category', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'importance' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('additionalinformation', [
            'id' => Schema::TYPE_BIGPK,
            'category_id' => Schema::TYPE_INTEGER,
            'information' => Schema::TYPE_TEXT,
            'source_id' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('ai_word', [
            'id' => Schema::TYPE_BIGPK,
            'ai_id' => Schema::TYPE_BIGINT,
            'word_id' => Schema::TYPE_BIGINT,
        ]);
        $this->createTable('ai_translation', [
            'id' => Schema::TYPE_BIGPK,
            'ai_id' => Schema::TYPE_BIGINT,
            'translation_id' => Schema::TYPE_BIGINT,
        ]);

        $this->addForeignKey('fk_ai_category', 'additionalinformation', 'category_id', 'ai_category', 'id', 'CASCADE');
        $this->addForeignKey('fk_ai_source', 'additionalinformation', 'source_id', \app\models\Source::tableName(), 'id', 'CASCADE');
        $this->addForeignKey('fk_ai_word', 'ai_word', 'word_id', app\models\Word::tableName(), 'id', 'CASCADE');
        $this->addForeignKey('fk_ai_word_ai', 'ai_word', 'ai_id', 'additionalinformation', 'id', 'CASCADE');
        $this->addForeignKey('fk_ai_translation', 'ai_translation', 'translation_id', app\models\Translation::tableName(), 'id', 'CASCADE');
        $this->addForeignKey('fk_ai_translation_ai', 'ai_translation', 'ai_id', 'additionalinformation', 'id', 'CASCADE');

        $this->createIndex('idx_ai_category', 'ai_category', ['name'], true);
        $this->createIndex('idx_ai_word', 'ai_word', ['ai_id', 'word_id'], true);
        if (\Yii::$app->db->getDriverName() == 'pgsql') {
            $this->execute('CREATE INDEX "ft_ai_information" ON "additionalinformation" USING gin(to_tsvector(\'simple\',"information"));');
        } else if (\Yii::$app->db->getDriverName() == 'mysql') {
            $this->execute('CREATE FULLTEXT INDEX ft_ai_word ON `additionalinformation` (information);');
        }
        $this->createIndex('idx_ai_translation', 'ai_translation', ['ai_id', 'translation_id'], true);
    }

    public function safeDown() {
        $this->dropIndex('idx_ai_translation ', 'ai_translation');
        $this->dropIndex('idx_ai_word', 'ai_word');
        $this->dropIndex('idx_ai', 'additionalinformation');
        $this->dropIndex('idx_ai_category', 'ai_category');

        $this->dropForeignKey('fk_ai_translation_ai', 'ai_translation');
        $this->dropForeignKey('fk_ai_translation', 'ai_translation');
        $this->dropForeignKey('fk_ai_word_ai', 'ai_word');
        $this->dropForeignKey('fk_ai_word', 'ai_word');
        $this->dropForeignKey('fk_ai_source', 'additionalinformation');
        $this->dropForeignKey('fk_ai_category', 'additionalinformation');

        $this->delete('additionalinformation_translation');
        $this->delete('additionalInformation_word');
        $this->delete('additionalInformation');
        $this->delete('ai_category');
    }

}
