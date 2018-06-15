<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aple`.
 */
class m180615_121724_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apple', [
            'id' => $this->primaryKey()->unsigned(),
            'date_appearance' => $this->dateTime()->notNull(),
            'date_fall_to_ground' => $this->dateTime()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'status' => $this->tinyInteger('1')->null(),
            'spoiled_apple' => $this->tinyInteger('1')->null(),
            'percentage_eaten' => $this->integer('3'),
            'r_rgb' => $this->tinyInteger('3')->unsigned()->notNull(),
            'g_rgb' => $this->tinyInteger('3')->unsigned()->notNull(),
            'b_rgb' => $this->tinyInteger('3')->unsigned()->notNull(),
            'change_color' => $this->string('11'),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apple');
    }
}
