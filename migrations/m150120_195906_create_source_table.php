<?php

use yii\db\Schema;
use yii\db\Migration;
use app\models\Translation;
use app\models\Source;

class m150120_195906_create_source_table extends Migration {

    public function safeUp() {
        $this->createTable(Source::tableName(), array(
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'link' => Schema::TYPE_STRING,
        ));
        $this->createIndex('idx_src1', Source::tableName(), ['name'], true);
        $this->addColumn(\app\models\Translation::tableName(), 'src_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('fk_translation_src_id', Translation::tableName(), 'src_id', Source::tableName(), 'id');
    }

    public function safeDown() {
        $this->dropIndex('idx_src1', Source::tableName());
        $this->dropForeignKey('fk_translation_src_id', Translation::tableName());
        $this->dropColumn(Translation::tableName(), 'src_id');
        $this->dropTable(Source::tableName());
    }

}
