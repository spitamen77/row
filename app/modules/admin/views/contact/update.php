<?php

use yii\helpers\Html;
use app\models\Lang;
/* @var $this yii\web\View */
/* @var $model app\models\ContactForm */

$this->title = Lang::t('Update').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contact Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contact-form-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
