<?php
/**
 * Created by PhpStorm.
 * User: Aleksei
 * Date: 29.01.2019
 * Time: 10:51
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
?>

<?php $form = ActiveForm::begin() ?>
<div>
<?= $form->field($model, 'cinema_id')->dropDownList(\app\models\Cinema::getFilms(), ['prompt' => '-- выберите кино --']) ?>
<?= $form->field($model, 'cinema_hall_id')->dropDownList(\app\models\CinemaHall::getHalls(), ['prompt' => '-- выберите зал --']) ?>
<?= $form->field($model, 'time_start')->widget('kartik\datetime\DateTimePicker', [
    'name' => 'dp_3',
    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
    'value' => '2019-01-01 00:00:00',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd hh:ii:ss'
    ]
]) ?>
<?= $form->field($model, 'time_end')->widget('kartik\datetime\DateTimePicker', [
    'name' => 'dp_3',
    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
    'value' => '2019-01-01 00:00:00',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd hh:ii:ss'
    ]
]) ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>
