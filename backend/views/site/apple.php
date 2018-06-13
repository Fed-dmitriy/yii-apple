<?php
/**
 * Created by PhpStorm.
 * User: DMITRIY
 * Date: 10.06.2018
 * Time: 12:33
 */

use yii\helpers\Html;
?>
<?= Html::a('Добавить в корзину', ['/apple/apple', 'generate'=>1]); ?>
<?php

print_r($model);

