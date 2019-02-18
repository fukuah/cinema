<?php
/**
 * Created by PhpStorm.
 * User: Aleksei
 * Date: 29.01.2019
 * Time: 11:17
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
?>

<?php $form = ActiveForm::begin() ?>
<div>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 10]) ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>