<?php

use yii\db\Schema;
use yii\db\Migration;

class m150117_144646_update_dictionary_table extends Migration {

    public function safeUp() {
        $this->addColumn(\app\models\Dictionary::tableName(), 'active', Schema::TYPE_BOOLEAN);
        foreach (\app\models\Dictionary::find()->all() as $dict) {
            $dict->active = true;
            $dict->update();
        }
    }

    public function safeDown() {
        return true;
    }

}
