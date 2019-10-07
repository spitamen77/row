<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <a href='javascript:history.back()' class='btn btn-danger'>ortga</a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'username',
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
            // 'wrong_pass',
            'tel',
            // 'admin_seen',
            // 'image',
            'fio',
            // 'tel',
            'birthdate',
            // 'created_at',
            [
              'attribute' => 'created_at',
              'filter' => false,
              // 'format' => 'raw',
               'value' => function ($model) {
                   return  date("Y-m-d",$model->created_at);
               },
            ],
            [
             'attribute' =>  Lang::t("Rasm"),
             'format' => 'raw',
             'value' => function ($model) {   
                if (!empty($model->image))
                  return '<img src="/web/'.$model->image.'" width="160px" height="auto">'; 
                else return Lang::t('Rasm yuklanmagan');
             },
            ],
            // 'updated_at',
        ],
    ]) ?>

</div>
