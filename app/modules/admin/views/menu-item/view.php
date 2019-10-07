<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\MenuItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Lang::t('Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-item-view">

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
        <a href='javascript:history.back()' class='btn btn-danger'><?=Lang::t("Back")?></a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'menu_id',
            [
              'attribute' => 'menu_id',
               'value' => function ($model) {
                   return  $model->getMenuTitle($model->menu_id);
               },
            ],
//            'title',
            [
                'attribute' => 'title',
                'value' => $lang->title
            ],
            // 'photo',
            [
                'attribute' => 'short',
                'value' => $lang->short
            ],
            [
                'attribute' => 'text',
                'value' => $lang->text
            ],
            'slug',
            'views',
            // 'status',
            [
              'attribute' => 'status',
               'value' => function ($model) {
                   return  $model->getStatus()[$model->status];
               },
            ],
            // 'price',
            [
              'attribute' => 'price',
               'value' => function ($model) {
                   return number_format($model->price, 0, ',', ' ');
               },
            ],
            'sale',
            [
                'attribute' => 'teacher_id',
                'value' => function ($model) {
                    return  $model->getTeacher()[$model->teacher_id];
                },
            ],
            'time',
            [
                'attribute' =>  Lang::t("File"),
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->file))
                        return '<a href="/web/'.$model->file.'" target="_blank">'.$model->file.'</a>';
                    else return Lang::t('Fayl yuklanmagan');
                },
            ],
            [
             'attribute' =>  Lang::t("Rasm"),
             'format' => 'raw',
             'value' => function ($model) {   
                if (!empty($model->photo))
                  return '<img src="/web/'.$model->photo.'" width="320px" height="auto">'; 
                else return Lang::t('Rasm yuklanmagan');
             },
            ],
            // 'user_id',
            // 'created_date',
            // 'updated_date',
        ],
    ]) ?>

</div>
