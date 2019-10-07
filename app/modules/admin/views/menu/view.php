<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\Menu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Lang::t('Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Lang::t('Delete'), ['delete', 'id' => $model->id], [
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
            'title',
            'slug',
            // 'template_id',
            [
              'attribute' => 'template_id',
               'value' => function ($model) {
                   return  $model->getTemplate()[$model->template_id];
               },
            ], 
            'tree',
            // 'child',
            [
              'attribute' => 'child',
               'value' => function ($model) {
                   return  $model->getOta($model->child);
               },
            ], 
            [
              'attribute' => 'status',
               'value' => function ($model) {
                   return  $model->getStatus()[$model->status];
               },
            ],            // 'user_id',
//            'updated_date',
            [
                'attribute'=>'updated_date',
                'value'=>function($model){
                    return date('d-m-Y', $model->updated_date);
                }
            ],
        ],
    ]) ?>

</div>
