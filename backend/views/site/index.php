<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\services\AppleStatus;
use yii\helpers\Url;

?>
<?= Html::csrfMetaTags() ?>
<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="btn-group" role="group" aria-label="">
    <button type="button" class="btn btn-success"><?= Html::a('Сгенерировать яблоки в случайном количестве',
            ['site/generate', 'generate' => 1]); ?>
    </button>
</div>
<div class="btn-group" role="group" aria-label="">
    <button type="button" class="btn btn-danger"><?= Html::a('Удалить все яблоки',
            ['site/delete-apples-all', 'deleteApplesAll' => 1]); ?>
    </button>
</div>

<?php

//print_r($apples);
foreach ($apples as $apple):
    $size = 100 - $apple->percentage_eaten;
    if (!$apple->change_color) {
        $changeColor = "RGB(" . $apple->r_rgb . "," . $apple->g_rgb . "," . $apple->b_rgb . ")";
    } else {
        $changeColor = $apple->change_color;
    }

    ?>
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group" role="group" aria-label="third group">

            <div style="width: 70px; height: 70px"><img class="small" src="/backend/web/uploads/apple.png" alt="Яблоко"
                                                        style="background-color: <?=$changeColor;?>;
                                                            width: 90%;
                                                            border-top-left-radius: 40px;
                                                            border-top-right-radius: 50px;
                                                            border-bottom-left-radius: 40px;
                                                            border-bottom-right-radius: 40px;">
            </div>
        </div>
        <div class="warning">Яблоко находится на
            <?php if ($apple->status == AppleStatus::FALLEN) {
                echo "на земле";
            } else {
                echo "на дереве";
            } ?>
            <?php if ($apple->status == AppleStatus::FALLEN && $apple->spoiled_apple == AppleStatus::SPOILED) {
                echo ". Яблоко испортилось.";
            } else {
                echo ", его можно есть.";
            } ?>
            <?php if ($apple->status == AppleStatus::FALLEN && $apple->spoiled_apple === AppleStatus::NOT_SPOILED && $apple->percentage_eaten === 0 or $apple->status === AppleStatus::HANGING) {
                echo "Яблоко целое.";
            } elseif ($apple->status == AppleStatus::FALLEN && $apple->spoiled_apple === AppleStatus::NOT_SPOILED && $apple->percentage_eaten > 0) {
                echo "От яблока осталось: " . $size . "%";
            } ?>

        </div>
        <div class="btn-group" role="group" aria-label="First group">
            <button type="button" class="btn btn-warning"><?= Html::a('Уронить яблоко', ['site/fall-to-ground',
                    'fallToGround' => $apple->id] ); ?></button>
        </div>
        <div class="btn-group" role="group" aria-label="Second group">
            <button type="button" class="btn btn-danger"><?= Html::a('Удалить яблоко',
                    ['site/delete-apple-one', 'deleteAppleOne' => $apple->id]); ?></button>
        </div>
        <div class="btn-group" role="group" aria-label="Fifth group">
            <?php $form = ActiveForm::begin(['action' => Url::to(['site/eate'])]); ?>
            <?= Html::submitButton('Откусить яблоко, %', ['class' => 'btn btn-success']) ?>
            <?= $form->field($apple,
                'percentage_eaten')->label('')->textInput(['placeholder' => 'Откушено от яблока, %']); ?>
            <?= $form->field($apple, 'id')->hiddenInput()->label(false); ?>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="btn-group" role="group" aria-label="Six group">
            <?php $form = ActiveForm::begin(['action' => Url::to(['site/change-color'])]); ?>
            <?= Html::submitButton('Изменить цвет яблока', ['class' => 'btn btn-success']) ?>
            <?= $form->field($apple, 'change_color')->label('')->textInput(['placeholder' => 'Цвет в фомате HEX']); ?>
            <?= $form->field($apple, 'id')->hiddenInput()->label(false); ?>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

<?php endforeach; ?>


