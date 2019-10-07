<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\ShopcartOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shopcart Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shopcart-orders-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<!-- 
    <p>
        <?= Html::a('Create Shopcart Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'order_id',
            // 'auth_user',
            'name',
            'address',
            'phone',
            'email:email',
            // 'comment',
            //'remark',
            //'access_token',
            //'ip',
            //'payment',
            'time:datetime',
            //'new',
            // 'status',
            [
              'attribute' => 'status',
              'filter' => false,
              // 'format' => 'raw',
               'value' => function ($model) {
                   return  $model->getStatus()[$model->status];
               },
            ],
            //'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
