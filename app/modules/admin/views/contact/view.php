<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Lang;
/* @var $this yii\web\View */
/* @var $model app\models\ContactForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Lang::t('Contact us'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contact-form-view">

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
        <a class="btn btn-success" href='javascript:history.back()'><?=Lang::t('Back')?></a>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'name',
            'email:email',
            'subject',
            'body',
            // 'status',
        ],
    ]) ?>

</div>
