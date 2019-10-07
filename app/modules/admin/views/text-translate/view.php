<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Lang;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\dilshod\TextTranslate */

$this->title = $model->text;
$this->params['breadcrumbs'][] = ['label' => 'Text Translates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="text-translate-view">

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
        <a class="btn btn-success" href="<?=Url::to('index')?>"><?=Lang::t('Back')?></a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'lang',
            'slug',
            'text',
            'status',
//            'updated_date',
        ],
    ]) ?>

</div>
