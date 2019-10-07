<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lang;
/* @var $this yii\web\View */
/* @var $model app\models\dilshod\TextTranslate */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-6">
<div class="text-translate-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    <?//= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>-->
<?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
<?php endif;?>
    <?= $form->field($model, 'text')->textArea(['maxlength' => true]) ?>
<?php if (!$model->isNewRecord) : ?>
    <?= $form->field($model, 'status')->dropDownList([
        '1' => Lang::t('Aktiv'),
        '0' => Lang::t('Nofaol'),
    ]); ?>
<?php endif;?>
<!--    <?//= $form->field($model, 'updated_date')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a href='javascript:history.back()' class='btn btn-danger'>ortga</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>