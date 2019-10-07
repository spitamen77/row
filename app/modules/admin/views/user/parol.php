<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\Menu */

$this->title = 'Update Menu: ' . $model->username;
// $this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>
    	<!-- $model = Yii::$app->user->identity; -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
