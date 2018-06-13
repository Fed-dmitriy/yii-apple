<?php
/**
 * Created by PhpStorm.
 * User: DMITRIY
 * Date: 12.06.2018
 * Time: 2:34
 */

namespace backend\services;

use Yii;
use backend\models\Apple;
use backend\services\AppleStatus;//подключаем класс с константами состояния яблока

class AppleService
{
    //логика обработки действия "сгенерировать яблоки"
    public function generate()
    {
        $count_apple = mt_rand(AppleStatus::MIN_NUMBER, AppleStatus::MAX_NUMBER);
        $i = 0;
        while ($i <= $count_apple) {
            $apple = new Apple();
            $apple->date_appearance = date('Y-m-d H:i:s', time());
            $apple->r_rgb = mt_rand(0, 255);
            $apple->g_rgb = mt_rand(0, 255);
            $apple->b_rgb = mt_rand(0, 255);
            $apple->save();
            $i++;
        }
        return true;
    }
    //логика обработки действия "Удалить все яблоки"
    public function deleteApplesAll()
    {
        $count = Apple::find()->count();
        if ($count > 0) {
            Apple::deleteAll();
            return true;
        }
    }
    //логика обработки действия "Удалить одно яблоко"
    public function deleteAppleOne($id)
    {
        $apple = Apple::findOne($id);
        $apple->delete();
        return true;
    }
    //логика обработки действия "Уронить яблоко на землю"
    public function fallToGround($id=null)
    {
        $apple = Apple::findOne($id);
        if ($apple->status !== AppleStatus::FALLEN) {
            $apple->status = AppleStatus::FALLEN;
            $apple->date_fall_to_ground = date('Y-m-d H:i:s', time());
            $apple->save();
            return true;
        }
    }
    //логика обработки действия "Изменить цвет яблока"
    public function changeColor($id, $changeColor)
    {
        if(!$changeColor){
            return false;
        }else{
            $apple = Apple:: findOne($id);
            $apple->change_color = $changeColor;
            $apple->save();
            return true;
        }

    }
    //логика обработки действия "Съесть яблоко", смотреть совместно с классом EatResult
    public function eat($id, $percentageEaten)
    {
        $apple = Apple:: findOne($id);
        $apple->percentage_eaten = $percentageEaten;
        if ($apple->status === AppleStatus::HANGING) {
            return AppleStatus::CAN_NOT_EAT_ON_TREE;
        } elseif ($apple->spoiled_apple == AppleStatus::SPOILED && $apple->status == AppleStatus::FALLEN) {
            return AppleStatus::CAN_NOT_EAT_SPOILED;
        } else {
            if ($apple->percentage_eaten > 0 && $apple->percentage_eaten < 100) {
                $apple->save();
                return AppleStatus::EAT_SUCCESS;
            } elseif ($apple->percentage_eaten == 100) {
                $apple = Apple::findOne($id);
                $apple->delete();
                return AppleStatus::ATE_WHOLE_APPLE;
            }else{
                return AppleStatus::EAT_WRONG;
            }
        }
    }
    //логика изменения состояния яблока с целого на испорченное
    public function spoiledApple()
    {
        $apples = Apple::find()->all();
        foreach ($apples as $apple) {
            $interval = time() - strtotime($apple->date_fall_to_ground);
            if ($apple->spoiled_apple != AppleStatus::SPOILED && $interval >= AppleStatus::INTERVAL && $apple->status != AppleStatus::HANGING) {
                $apple->spoiled_apple = AppleStatus::SPOILED;
                $apple->save();
            }
        }
    }
}