<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lang;

/* @var $this yii\web\View */
/* @var $model app\models\dilshod\MenuItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($lang, 'lang')->dropDownList($lang->getLang()) ?>
    <?= $form->field($model, 'menu_id')->dropDownList($model->getMenu()); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <!-- <div class="form-control">
        <label class="control-label" for="checkbox"><?=Lang::t('Auksion savdo')?></label>
        <input type="checkbox" name="checkbox">
    </div> -->
    <div id="display" style="display: none;">
    <?= $form->field($model, 'price')->textInput(['class' => 'your form-control']) ?>

    <?= $form->field($model, 'sale')->textInput(['class' => 'your form-control']) ?>
     <?= $form->field($model, 'pieces')->textInput(['class' => 'your form-control']) ?>
    </div>
    <?= $form->field($model, 'photo')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJs('

         $("#menuitem-menu_id").on(\'change\', function () {
            var value = $(this).val();
            $.get("updatetext",{val:value},function(response){
                if(response=="success") {
                    console.log("success");
                $("#display").hide();}
            else $("#display").show();
        });
        });
    ');
?>


