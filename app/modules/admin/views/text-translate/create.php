<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\TextTranslate */

$this->title = 'Create Text Translate';
$this->params['breadcrumbs'][] = ['label' => 'Text Translates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-translate-create">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="text-danger">
        <?php 
            if (isset($error)) {
                echo $error;
            }
        ?>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
