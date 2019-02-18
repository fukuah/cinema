<?php
/**
 * Created by PhpStorm.
 * User: Aleksei
 * Date: 29.01.2019
 * Time: 12:11
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;



$script = <<<JS
$( document ).ready(function() {
    $('#row').change(function() {
        $('#order_but').attr('href', function(i,a){
            var row = $('#row').val();
            var col =$('#col').val();
            var id =$('#session').val();
            return a.replace('/index.php?r=site%2Forder-ticket' + '&id=' + id + '&row=' + row + '&col=' + col);
        });
    });
    
     $('#col').change(function() {
        $('#order_but').attr('href', function(i,a){
            var row = $('#row').val();
            var col =$('#col').val();
            var id =$('#session').val();
            return a.replace('/index.php?r=site%2Forder-ticket' + '&id=' + id + '&row=' + row + '&col=' + col);
        });
    });
});
JS;


$this->registerJS($script, \yii\web\View::POS_END)
?>

<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'cinema_id',
                'value' => function($model){
                    return $model->film->name;
                }
            ],
            'time_start',
            'time_end',
            'cinema_hall_id',
            [
                'header' => 'Book ticket',
                'format' => 'raw',
                'value' => function($model){
                    return
                        Html::hiddenInput('ID', $model->id, ['id' => 'session']) .
                        'Ряд: ' . Html::dropDownList('Ряд', 1, range(1, $model->hall->seat_row), ['id' =>  'row']) . ' ' .
                        'Место: ' . Html::dropDownList('Место', 1, range(1, $model->hall->seat_col), ['id' =>  'col']) . ' ' .
                        Html::a('Заказать', Url::to(['order-ticket', 'id' => $model->id, 'row' => 1, 'col' => 1]), ['id' => 'order_but','class' => 'btn btn-success']);
                }
            ]
        ]
    ])
?>