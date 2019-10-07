<?php

use app\models\Lang;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\MenuItem */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => Lang::t('Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
