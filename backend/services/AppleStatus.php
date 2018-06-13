<?php
/**
 * Created by PhpStorm.
 * User: DMITRIY
 * Date: 12.06.2018
 * Time: 14:09
 */

namespace backend\services;


class AppleStatus
{
    const MIN_NUMBER = 1; //минимальное количество яблок, генерируемых случайно
    const MAX_NUMBER = 10; //максимальное количество яблок, генерируемых случайно
    const HANGING = null; //яблоко висит
    const FALLEN = 1; //яблоко упало
    const SPOILED = 1;//яблоко испорченное
    const NOT_SPOILED = null;
    const INTERVAL = 5*60*60;//интервал времени в секундах через который яблоко испортится, в данном случае переводим 5 часов в секунды
    const CAN_NOT_EAT_ON_TREE = 1;//яблоко висити на дереве, нельзя съесть
    const CAN_NOT_EAT_SPOILED = 2;//яблоко испортилось, нельзя съесть
    const EAT_SUCCESS = 3; //успешно откусили яблоко
    const ATE_WHOLE_APPLE = 4;//съели все яблоко
    const EAT_WRONG = 5;
    
}