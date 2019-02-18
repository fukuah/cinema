<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cinema_hall".
 *
 * @property int $id
 * @property int $seat_row
 * @property int $seat_col
 */
class CinemaHall extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cinema_hall';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seat_row', 'seat_col'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seat_row' => 'Seat Row',
            'seat_col' => 'Seat Col',
        ];
    }

    public static function getHalls(){
        return ArrayHelper::map(self::find()->all(), 'id', 'id');
    }
}
