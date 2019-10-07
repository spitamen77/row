<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Lang;
/* @var $this yii\web\View */
/* @var $model app\models\dilshod\Photo */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
  .img-thumbnail {
    height: 75px;
    border: 1px solid #000;
    margin: 10px 5px 0 0;
  }
</style>
<div class="container">
   
<div class="row">
        <span id="output"></span>
    </div>
</div>  
<a href='javascript:history.back()' class='btn btn-success'><?=Lang::t("Back")?></a>
<div class="photo-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]); ?>
<?php endif;?>
   
    <?= $form->field($model, 'info_uz')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'info_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'info_en')->textInput(['maxlength' => true]) ?>

<?php if (!$model->isNewRecord) : ?>
    <?= $form->field($model, 'status')->dropDownList($model->getStatus()); ?>
<?php endif;?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
  
<script>
function handleFileSelectSingle(evt) {
    var file = evt.target.files; // FileList object

    var f = file[0]

      // Only process image files.
      if (!f.type.match('image.*')) {
        alert("Только изображения....");
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="img-thumbnail" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('output').innerHTML = "";
          document.getElementById('output').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
document.getElementById('photo-image').addEventListener('change', handleFileSelectSingle, false);





</script>
<?php
    $this->registerJs('
var formData = new FormData();
$("input[type=file]").change(function() { 
    var $this = $(this);
    $.ajax({
            url: $this.closest(\'form\').attr(\'action\'),
            dataType: \'json\',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: \'post\',
            success: function(response){
                if(response == \'success\'){
                    
                } else condole.log(response);
            }
        });
            
});

//         $("input[type=file]").change(function() { 
//             var photo = $("photo-image").val();
//             var value = $("photo-slug").val();
//         $.post("create",{val:value,image:photo},function(response){
//             if(response=="success") {
//                 console.log(response);
//             }
//             else console.log(response);
//         });
//         // $("form").submit(); 
// });

// alert(files);
         $("input[type=file]").on(\'click\', function () {
        //     var value = $(this).val();
        //     $.get("updatetext",{val:value},function(response){
        //         if(response=="success") {
        //             console.log("success");
        //         $("#display").hide();}
        //     else $("#display").show();
        // });
        });
    ');
?>