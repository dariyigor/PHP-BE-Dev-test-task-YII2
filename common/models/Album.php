<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Album
 * @package common\models
 *
 */
class Album extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }
}
