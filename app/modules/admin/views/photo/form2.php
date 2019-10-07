<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Lang;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    #uploadImagesList {
        list-style: none;
        padding: 0;
    }
    #uploadImagesList .item {
        float: left;
        margin-right: 20px;
        margin-bottom: 20px;
    }
    #uploadImagesList .item .img-wrap {
        width: inherit;
        display: block;
        height: 150px;
    }
    #uploadImagesList .item .img-wrap img{
        width: auto;
        height: inherit;
    }
    #uploadImagesList .item .delete-link {
        cursor: pointer;
        display: block;
    }

  #uploadImagesList2 {
        list-style: none;
        padding: 0;
    }
    #uploadImagesList2 .item {
        float: left;
        margin-right: 20px;
        margin-bottom: 20px;
    }
    #uploadImagesList2 .item .img-wrap {
        width: inherit;
        display: block;
        height: 150px;
    }
    #uploadImagesList2 .item .img-wrap img{
        width: auto;
        height: inherit;
    }
    #uploadImagesList2 .item .delete-link {
        cursor: pointer;
        display: block;
    }

    .clear {
        clear: both;
    }

#progress-bar {
    margin-top: 20px;
    width: 300px;
    height: 20px;
    background: #999999;
    position: relative;
}
#progress-bar .progress-bg {
    position: absolute;
    width: 0;
    height: inherit;
    background: green;
}
#progress-bar .progress-val {
    position: absolute;
    text-align: center;
    width: inherit;
    height: inherit;
} 
  
</style>
<div class="container">
   
<div class="row">
        <span id="output"></span>
    </div>
</div>  
<div class="photo-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'action'=>Url::to(['photo/save', 'id' => $kod])]); ?>

    <!-- <input type="file" id="photo-image" multiple=""> -->
    <?= $form->field($model, 'src[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

<ul id="uploadImagesList2">
  <li class="item template">
            <span class="img-wrap">
                <img src="" alt="">
            </span>
            <span class="delete-link" title="Удалить"><?=Lang::t("Delete")?></span>
        </li>
</ul>  

  <?php if (!empty($image)) : ?>
<ul id="uploadImagesList">
    <?php foreach ($image as $item) : ?>
        <li class="item template">
            <span class="img-wrap">
                <img src="/web/<?=$item->src?>" alt="">
            </span>
            <span class="delete-link" title="Удалить" data-id="<?=$item->id?>"><?=Lang::t("Delete")?></span>
        </li>
    <?php endforeach; ?>    
 
    </ul>
  <?php endif; ?>      
 
    <div class="clear"></div>
    <div id="progress-bar">
    <div class="progress-bg"></div>
    <div class="progress-val">0%</div>
</div>
<br>
    <div class="form-group">
    </div>


    <?php ActiveForm::end(); ?>
        <a href='javascript:history.back()' class='btn btn-danger'><?=Lang::t("Back")?></a>

</div>
  
  
<script>
jQuery(document).ready(function ($) {
var maxFileSize = 2 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
     var queue = {};
     var form = $('form#w0');
     var imagesList = $('#uploadImagesList2');
     var imagesList2 = $('#uploadImagesList');
 
     var itemPreviewTemplate = imagesList.find('.item.template').clone();
     itemPreviewTemplate.removeClass('template');
     // imagesList.find('.item.template').remove();
 
 
     $('#rasm-src').on('change', function () {
         var files = this.files;

         for (var i = 0; i < files.length; i++) {
             var file = files[i];
 
             if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
                 alert( 'Фотография должна быть в формате jpg, png или gif' );
                 continue;
             }
 
             if ( file.size > maxFileSize ) {
                 alert( 'Размер фотографии не должен превышать 2 Мб' );
                 continue;
             }
 
             preview(files[i]);
         }
 
         this.value = '';
     });
 
     // Создание превью
     function preview(file) {

var formData = new FormData();
formData.append('file', $('#rasm-src')[0].files[0]);
// alert($('form#w0').attr('action'));

$.ajax({
       url : $('form#w0').attr('action'),
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       async: true,
       cache: false,
       enctype: 'multipart/form-data',
       success : function(data) {
           console.log(data.result);
           var reader = new FileReader();
         reader.addEventListener('load', function(event) {
             var img = document.createElement('img');
 
             var itemPreview = itemPreviewTemplate.clone();
 
             itemPreview.find('.img-wrap img').attr('src', event.target.result);
             itemPreview.find('.delete-link').attr('data-id', data.id);
             itemPreview.data('id', file.name);
 
             imagesList.append(itemPreview);
 
             queue[file.name] = file;
 
         });
         reader.readAsDataURL(file);
       }
});

         
     }
 
     // Удаление фотографий
     imagesList.on('click', '.delete-link', function () {
        var value = $(this).attr("data-id");
        var item = $(this).closest('.item'),
        id = item.data('id');
      $.get("delimage",{val:value},function(response){
                if(response=="success") {
                  console.log(response);
                 delete queue[id];
         
                 item.remove();
              }
            else console.log(response);
            });
  
     });

     imagesList2.on('click', '.delete-link', function () {
        var value = $(this).attr("data-id");
        var item = $(this).closest('.item'),
        id = item.data('id');
      $.get("delimage",{val:value},function(response){
                if(response=="success") {
                  console.log(response);
                 delete queue[id];
         
                 item.remove();
              }
            else console.log(response);
            });
  
     });

});
</script>
 <!--      form.on('submit', function(event) {
 
//     var formData = new FormData(this);
 
//     for (var id in queue) {
//         formData.append('images[]', queue[id]);
//     }
 
//     $.ajax({
//         url: $(this).attr('action'),
//         type: 'POST',
//         data: formData,
//         async: true,
//         xhr: function() {
//             var xhr = new window.XMLHttpRequest();
//             var progressBar = $('#progress-bar'),
//                 progressBg = progressBar.find('.progress-bg'),
//                 progressVal = progressBar.find('.progress-val');
 
//             // Upload progress
//             xhr.upload.addEventListener("progress", function(evt){
//                 if (evt.lengthComputable) {
//                     var percentComplete = evt.loaded / evt.total;
//                     percentComplete = (percentComplete * 100).toFixed();
 
//                     progressBg.css('width', percentComplete + '%');
//                     progressVal.text(percentComplete + '%');
 
//                     // console.log(percentComplete);
//                 }
//             }, false);
 
//             return xhr;
//         },
//         success: function (res) {
//             //alert(res)
//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
 
//     return false;
// }); 
 -->




