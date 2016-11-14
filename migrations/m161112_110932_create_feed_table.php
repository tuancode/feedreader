<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feed`.
 */
class m161112_110932_create_feed_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('feed', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'link' => $this->string()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'pubDate' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `category_id`
        $this->createIndex('idx-feed-category_id', 'feed', 'category_id');

        // add foreign key for table `category`
        $this->addForeignKey('fk-feed-category_id', 'feed', 'category_id', 'category', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('feed');
    }
}
