<?php
/**
 * Created by PhpStorm.
 * User: DMITRIY
 * Date: 12.06.2018
 * Time: 14:29
 */

namespace backend\services;


class AppleActionMessage
{
    const GENERATE_SUCCESS = 'Яблоки успешно сгенерированы';
    const DELETE_ALL_SUCCESS = 'Яблоки успешно удалены';
    const DELETE_ONE_SUCCESS = 'Яблокo успешно удаленo';
    const DELETE_ALL_ERROR = 'Нет яблок для удаления';
    const DELETE_ONE_ERROR = 'Произошла ошибка. Яблоко не удалилось';
    const FALL_To_GROUND_SUCCESS = 'Яблоко успешно упало';
    const ALREADY_ON_GROUND = 'Яблоко уже лежит на земле';
    const CHANGE_COLOR_SUCCESS = 'Цвет успешно изменен';
    const CHANGE_COLOR_ERROR = 'Произошда ошибка при изменении цвета';
    const CAN_NOT_EAT_ON_TREE = 'К сожалению яблоко висит на дереве, его нельзя съесть. Надо чтобы оно упало';
    const CAN_NOT_EAT_SPOILED = 'К сожалению яблоко испортилось, его нельзя съесть';
    const EAT_SUCCESS = "Успешно откусили яблоко";
    const ATE_WHOLE_APPLE = 'Вы съели полностью яблоко';
    const EATE_WRONG = 'Введено некорректное значение';
}