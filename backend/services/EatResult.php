<?php
/**
 * Created by PhpStorm.
 * User: DMITRIY
 * Date: 12.06.2018
 * Time: 20:40
 */

namespace backend\services;
use backend\services\AppleService;
use Yii;
use backend\services\AppleStatus;//подключаем класс с константами состояния яблока
use backend\services\AppleActionMessage;//подключаем класс с константами, в которых содержатся щаблоны сообщений, в зависимости от результата обработки действия actionEate будет принимать соответствующее значение

class EatResult
{
    protected $isSuccess;//свойство, которое определяет тип flash сообщения (success, danger и т.д.) в зависимости от результата
    protected $message;//текст сообщения передааваемый как результат в actionEate
    protected $result;//в данное свойство будет попадать результат логической обработки Eate()
    //метод обработки результата
    public function setResult($id, $persantageEaten)
    {
        $appleService = new AppleService();
        $this->result = $appleService->eat($id, $persantageEaten);
        if ($this->result === AppleStatus::CAN_NOT_EAT_ON_TREE){
            $this->isSuccess = 'danger';
            $this->message = AppleActionMessage::CAN_NOT_EAT_ON_TREE;
        }elseif($this->result === AppleStatus::CAN_NOT_EAT_SPOILED) {
            $this->isSuccess = 'danger';
            $this->message = AppleActionMessage::CAN_NOT_EAT_SPOILED;
        }elseif ($this->result === AppleStatus::EAT_SUCCESS) {
            $this->isSuccess = 'success';
            $this->message = AppleActionMessage::EAT_SUCCESS;
        }elseif ($this->result === AppleStatus::ATE_WHOLE_APPLE){
            $this->isSuccess = 'danger';
            $this->message = AppleActionMessage::ATE_WHOLE_APPLE;
        }elseif($this->result === AppleStatus::EAT_WRONG){
            $this->isSuccess = 'danger';
            $this->message = AppleActionMessage::EAT_WRONG;
        }
    }
    //метод подготовки сообщения с полученными свойствами $this->isSuccess, $this->message в методе setResult()
    public function setMessage()
    {
        Yii::$app->session->setFlash($this->isSuccess, $this->message);
    }
}
