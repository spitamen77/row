<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lang;
/* @var $this yii\web\View */
/* @var $model app\models\ContactForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Lang::t('Save'), ['class' => 'btn btn-success']) ?>
        <a class="btn btn-primary" href='javascript:history.back()'><?=Lang::t('Back')?></a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
