<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\MenuItemTransSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Item Trans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-trans-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Menu Item Trans', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'item_id',
            'lang',
            'title',
            'short',
            //'text:ntext',
            //'status',
            //'updated_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
