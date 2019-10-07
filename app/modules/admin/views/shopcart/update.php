<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShopcartOrders */

$this->title = 'Update Shopcart Orders: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shopcart Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shopcart-orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
