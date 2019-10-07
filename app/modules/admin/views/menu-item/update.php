<?php

use yii\helpers\Html;
// use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lang;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model app\models\dilshod\MenuItem */

$this->title = 'Update Menu Item: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Menu Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-item-update">

<div class="menu-item-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($lang, 'lang')->dropDownList($lang->getLang(),['options' =>[(isset($_GET['lang']))?$_GET['lang']:'uz-UZ' => ['Selected' => true]],['data-id'=>$model->id]]) ?>
    

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'text')->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
    'language' => 'es',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>
    <!-- <div class="form-control">
        <label class="control-label" for="checkbox"><?=Lang::t('Auksion savdo')?></label>
        <input type="checkbox" name="checkbox">
    </div> -->
    <div id="display" style="display: <?=($model->template->template_id==1)?"none":"block"?>;">
    <?= $form->field($model, 'price')->textInput(['class' => 'your form-control']) ?>
    <?= $form->field($model, 'sale')->textInput(['class' => 'your form-control']) ?>
    <?= $form->field($model, 'teacher_id')->dropDownList($model->getTeacher()); ?>
    <?= $form->field($model, 'time')->textInput(['placeholder' => '12.09.2019']) ?>
    <?= $form->field($model, 'file')->fileInput() ?>
    </div>
    <?= $form->field($model, 'photo')->fileInput() ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatus());?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a href='javascript:history.back()' class='btn btn-danger'>ortga</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
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
        $("#menuitemtrans-lang").on(\'change\', function () {
            var value = $(this).val();
            var id = $("#menuitemtrans-lang").attr("0-data-id");
            console.log(id);
            $.get("updatelang",{val:value,id:id},function(response){
                if(response=="success") {
                    console.log("success");
                $("#display").hide();}
            else $("#display").show();
        });
        });
    ');
?>




