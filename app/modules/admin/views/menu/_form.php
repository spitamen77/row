<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\Menu */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-8">
<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'child')->dropDownList($model->getMenu()); ?>
   <?= $form->field($model, 'tree')->textInput(['type' => 'number']) ?>


    <?= $form->field($model, 'template_id')->dropDownList($model->getTemplate()); ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatus()); ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a href='javascript:history.back()' class='btn btn-danger'>ortga</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
