<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Lang::t('Contact us');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="contact-form-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('Create Contact Form', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'email:email',
            'subject',
            'body',
            [
                'attribute' => 'status',
                'filter' => false,
                'value' => function ($model) {
                    return  $model->getStatus()[$model->status];
                },
            ],
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
