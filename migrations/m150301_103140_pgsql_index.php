<?php

use yii\db\Schema;
use yii\db\Migration;

class m150301_103140_pgsql_index extends Migration {

    public function safeUp() {
        if (\Yii::$app->db->getDriverName() == 'pgsql') {
            $this->dropIndex('ft_idx_word_simple', 'word');
            $this->execute(
                    'CREATE UNIQUE INDEX idx_word_word_language_id
        ON word
        USING btree
                (word, language_id);');
            $this->execute('CREATE EXTENSION IF NOT EXISTS pg_trgm');
            $this->execute('CREATE INDEX ft_idx_word_gin
  ON word
  USING gin
  (word gin_trgm_ops);');
        }
    }

    public function safeDown() {
        if (\Yii::$app->db->getDriverName() == 'pgsql') {
            $this->dropIndex('idx_word_word_language_id', 'word');
            $this->dropIndex('ft_idx_word_gin', 'word');
            $this->execute('CREATE INDEX "ft_idx_word_simple" ON "word" USING gin(to_tsvector(\'simple\',"word"));');
        }
    }

}
