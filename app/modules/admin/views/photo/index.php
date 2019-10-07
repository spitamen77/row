<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Lang;
use app\models\dilshod\Rasm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\dilshod\PhotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Photos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Photo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'slug',
            // 'image',
            [
             'attribute' =>  Lang::t("Rasm"),
             'format' => 'raw',
             'value' => function ($model) {   
                if (!empty($model->slug)){
                    $rasm = Rasm::find()->where(['photo_id'=>$model->id])->one();
                    if (!empty($rasm)) {
                        return '<img src="../../'.$rasm->src.'" width="120px" height="auto">'; 
                        # code...
                    }
                    else return Lang::t('Rasm yuklanmagan');
                }
                else return Lang::t('Rasm yuklanmagan');
             },
            ],
            'info_uz',
            'info_ru',
            'info_en',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>Lang::t('Amallar'),
                'headerOptions' => ['width' => '120'],
                'template' => '{link}  {update} {delete}',
                'buttons' => [
                    'link' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to(['photo/rasm', 'id' => $model->id]),
                            [
                                'title' => Lang::t('View'),
                                'class'=>'addModal',
                                'data-id'=>$model->id,
                                // 'data-toggle'=>'modal',
                                // 'data-target'=>'#addModal'
                            ]
                            );
                    },

                ],
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
