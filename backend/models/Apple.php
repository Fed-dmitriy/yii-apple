<?php
/**
 * Created by PhpStorm.
 * User: DMITRIY
 * Date: 10.06.2018
 * Time: 11:57
 */

namespace backend\models;
use Yii;
use yii\db\ActiveRecord;

class Apple extends ActiveRecord
{
    /*
     * в базе данных создана таблица apple, со следующими полями:
     *  date_appearance - время создания яблока
        date_fall_to_ground - время падения яблока
        status - стаутс определяющий на дереве яблоко или нет, по умолчанию null
        spoiled_apple - стаутс определяющий испорченное яблоко или нет, по умолчанию null
        percentage_eaten - процент съеденного яблока
        r_rgb - параметр, от 0 до 255 , определяющий цвет яблока (RGB() формат), при случайной генерации
        g_rgb - параметр, от 0 до 255 , определяющий цвет яблока (RGB() формат), при случайной генерации
        b_rgb - параметр, от 0 до 255 , определяющий цвет яблока (RGB() формат), при случайной генерации
        change_color - цвет введенный пользователем
     * */
    public static function tableName()
    {
        return 'apple';
    }

    public function attributeLabels()
    {
        return [
            'percentage_eaten' =>'Откушено от яблока, %',
        ];
    }
    public function rules()
    {
        //валидация формы вводимых данных
        return [
            ['percentage_eaten', 'integer', 'message' =>'Должно быть число до 100', 'max'=>100, 'min'=>0],
            ['change_color', 'match', 'pattern' => '/#[a-f0-9]{6}\b/i', 'message' =>'Цвет задается в формате HEX, например #ff9900'],
        ];
    }
}