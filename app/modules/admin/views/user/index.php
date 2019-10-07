<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'username',
            'fio',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            // 'status',
            [
              'attribute' => 'status',
              'filter' => false,
              // 'format' => 'raw',
               'value' => function ($model) {
                   return  $model->getStatus()[$model->status];
               },
            ],
            //'wrong_pass',
            'tel',
            // 'admin_seen',
            // 'image',
            // 'created_at',
            [
              'attribute' => 'created_at',
              'filter' => false,
              // 'format' => 'raw',
               'value' => function ($model) {
                   return  date("Y-m-d",$model->created_at);
               },
            ],
            // [
            //  'attribute' =>  Lang::t("Rasm"),
            //  'format' => 'raw',
            //  'value' => function ($model) {   
            //     if (!empty($model->image))
            //       return '<img src="/web/'.$model->image.'" width="64px" height="auto">'; 
            //     else return Lang::t('Rasm yuklanmagan');
            //  },
            // ],
            //'fio',
            //'tel',
            //'birthdate',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
