<?php

use yii\db\Schema;
use yii\db\Migration;

class m150228_224537_lowercase_columnnames extends Migration {

    public function safeUp() {
        $this->renameColumn(\app\models\UnknownWord::tableName(), 'searchRequest_id', 'searchrequest_id');
    }

    public function safeDown() {
        $this->renameColumn(\app\models\UnknownWord::tableName(), 'searchrequest_id', 'searchRequest_id');
    }

}
