<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Photo
 * @package common\models
 *
 */
class Photo extends ActiveRecord
{
    /**
     * @inheritDoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255]
        ];
    }
}
