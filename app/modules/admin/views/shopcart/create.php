<?php

use yii\helpers\Html;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $model app\models\ShopcartOrders */

$this->title = Lang::t('Create Shopcart Orders');
$this->params['breadcrumbs'][] = ['label' => 'Shopcart Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shopcart-orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
