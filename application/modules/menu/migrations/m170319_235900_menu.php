<?php
/**
 * @package    oakcms
 * @author     Hryvinskyi Volodymyr <script@email.ua>
 * @copyright  Copyright (c) 2015 - 2017. Hryvinskyi Volodymyr
 * @version    0.0.1-beta.0.1
 */

namespace app\modules\menu\migrations;

use yii\db\Schema;

class m170319_235900_menu extends \yii\db\Migration
{
    public function up()
    {
        // menu type
        $this->createTable('{{%menu_type}}', [
            'id'         => Schema::TYPE_PK,
            'title'      => Schema::TYPE_STRING . '(1024)',
            'alias'      => Schema::TYPE_STRING,
            'path'       => Schema::TYPE_STRING . '(2048)',
            'note'       => Schema::TYPE_STRING . '(255)',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER,
            'created_by' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_by' => Schema::TYPE_INTEGER,
            'lock'       => Schema::TYPE_BIGINT . ' UNSIGNED DEFAULT 1',
        ]);

        // menu item
        $this->createTable('{{%menu_item}}', [
            'id'             => Schema::TYPE_PK,
            'menu_type_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
            'parent_id'      => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'translation_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'status'         => Schema::TYPE_SMALLINT,
            'language'       => Schema::TYPE_STRING . '(7) NOT NULL',
            'title'          => Schema::TYPE_STRING . '(1024)',
            'alias'          => Schema::TYPE_STRING,
            'path'           => Schema::TYPE_STRING . '(1024)',
            'note'           => Schema::TYPE_STRING,
            'link'           => Schema::TYPE_STRING . '(1024)',
            'link_type'      => Schema::TYPE_SMALLINT,
            'link_weight'    => Schema::TYPE_SMALLINT . ' DEFAULT 0',
            'link_params'    => Schema::TYPE_TEXT,
            'layout_path'    => Schema::TYPE_STRING . '(1024)',
            'access_rule'    => Schema::TYPE_STRING . '(50)',
            'metakey'        => Schema::TYPE_STRING,
            'metadesc'       => Schema::TYPE_STRING . '(2048)',
            'robots'         => Schema::TYPE_STRING . '(50)',
            'secure'         => Schema::TYPE_BOOLEAN,
            'created_at'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'     => Schema::TYPE_INTEGER,
            'created_by'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_by'     => Schema::TYPE_INTEGER,
            'lft'            => Schema::TYPE_INTEGER,
            'rgt'            => Schema::TYPE_INTEGER,
            'level'          => Schema::TYPE_SMALLINT . ' UNSIGNED',
            'ordering'       => Schema::TYPE_INTEGER . ' UNSIGNED',
            'hits'           => Schema::TYPE_BIGINT . ' UNSIGNED',
            'lock'           => Schema::TYPE_BIGINT . ' UNSIGNED DEFAULT 1',
        ]);
        $this->createIndex('MenuTypeId_idx', '{{%menu_item}}', 'menu_type_id');
        $this->createIndex('ParentId_idx', '{{%menu_item}}', 'parent_id');
        $this->createIndex('TranslationId_idx', '{{%menu_item}}', 'translation_id');
        $this->createIndex('Lft_Rgt_idx', '{{%menu_item}}', 'lft, rgt');
        $this->createIndex('Language_idx', '{{%menu_item}}', 'language');
        $this->createIndex('Path_idx', '{{%menu_item}}', 'path');
        $this->createIndex('Alias_idx', '{{%menu_item}}', 'alias');
        $this->createIndex('Status_idx', '{{%menu_item}}', 'status');

        // Вставляєм рутовий елемент
        $this->insert('{{%menu_item}}', [
            'menu_type_id' => 0,
            'status'       => 1,
            'title'        => 'Root',
            'language'     => '',
            'created_at'   => time(),
            'created_by'   => 1,
            'lft'          => 1,
            'rgt'          => 2,
            'level'        => 1,
            'ordering'     => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%menu_type}}');
        $this->dropTable('{{%menu_item}}');
    }
}
