<?php

use yii\db\Migration;

/**
 * Class m220316_140035_user_album_photo
 */
class m220316_140035_user_album_photo extends Migration
{
    private const USER_TABLE_NAME = 'user';
    private const ALBUM_TABLE_NAME = 'album';
    private const PHOTO_TABLE_NAME = 'photo';

    private const USER_TABLE_FIRST_NAME_ = 'first_name';
    private const USER_TABLE_LAST_NAME_ = 'last_name';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::USER_TABLE_NAME, self::USER_TABLE_FIRST_NAME_, $this->char(255));
        $this->addColumn(self::USER_TABLE_NAME, self::USER_TABLE_LAST_NAME_, $this->char(255));

        $this->createTable(self::ALBUM_TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(0)->notNull(),
            'title' => $this->string(255)->defaultValue('')->notNull()
        ]);
        $this->createIndex('album_user_id', self::ALBUM_TABLE_NAME, 'user_id');

        $this->createTable(self::PHOTO_TABLE_NAME, [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer()->defaultValue(0)->notNull(),
            'title' => $this->string(255)->defaultValue('')->notNull(),
            'url' => $this->string(255)->defaultValue('')->notNull()
        ]);
        $this->createIndex('photo_album_id', self::PHOTO_TABLE_NAME, 'album_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::USER_TABLE_NAME, self::USER_TABLE_FIRST_NAME_);
        $this->dropColumn(self::USER_TABLE_NAME, self::USER_TABLE_LAST_NAME_);

        $this->dropTable(self::ALBUM_TABLE_NAME);
        $this->dropTable(self::PHOTO_TABLE_NAME);
    }
}
