<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $session_id
 * @property int $hall_id
 * @property int $place_num
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'session_id', 'hall_id', 'row', 'col'], 'required'],
            [['user_id', 'session_id', 'hall_id', 'row', 'col'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'session_id' => 'Session ID',
            'hall_id' => 'Hall ID',
            'place_num' => 'Place Num',
        ];
    }
}
