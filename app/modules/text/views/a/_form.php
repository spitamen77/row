<?php
    use uni\helpers\Html;
    use uni\widgets\Form;
    use app\components\widgets\TinyMce;
$def_lang=\app\models\Lang::getDefaultLang()->url;
if(!$model->isNewRecord){
    $this->registerJs('
$("#selectlang").change(function(){
        var tblock='.$model->text_id.';
        $.post("/admin/text/a/getranslation",{block:tblock,language:$(this).val()},function(data){
            if(data){
            data=JSON.parse(data);
              tinymce.get("text-t").setContent(data.text);
                $("#t-id").val(data.text_id);
            }else{
             tinymce.get("text-t").setContent("");
                $("#t-id").val("");
            }
            return false;
        });
});
');
}

?>
<div class="row content-box">
<?php $form = Form::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>
    <?if($model->isNewRecord){?>
            <div class="col-md-12 content-box" >
                    <?= $form->field($model, 'text')->widget(TinyMce::className(),[
                        'id'=>'text-t',
                        'clientOptions' => [
                            'id'=>'text-t',
                            'language' => 'ru',
                            'forced_root_block' => '',
                            'plugins' => [
                                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                'searchreplace wordcount visualblocks visualchars code fullscreen',
                                'insertdatetime media nonbreaking save table contextmenu directionality',
                                'emoticons template paste textcolor colorpicker textpattern imagetools'
                            ],
                            'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image| print preview media | forecolor backcolor emoticons',

                        ]
                    ]) ?>
            </div>
            <div class="col-md-12 content-box">
                <?= $form->field($model, 'slug') ?>
                <input type="hidden" name="id" id="t-id"/>
            </div>
  <?  }else{?>
    <div class="col-md-12 clearfix">
    <div class="col-md-8 " >
        <div class="form-group">
            <?= $form->field($model, 'text')->widget(TinyMce::className(),[
                'options'=>[
                    'id'=>'text-t',
                ],
                'clientOptions' => [
                    'id'=>'text-t',
                    'forced_root_block' => '',
                    'language' => 'ru',
                    'plugins' => [
                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                        'insertdatetime media nonbreaking save table contextmenu directionality',
                        'emoticons template paste textcolor colorpicker textpattern imagetools'
                    ],
                    'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image| print preview media | forecolor backcolor emoticons',
                ]
            ]) ?>
        </div>
    </div>
    <div class="col-md-4 ">
            <div class="form-group">
            <div class="col-md-12 content-box">
                <h4>Translation</h4>
                <?if(!$model->isNewRecord){?>
                    <select class="form-control" id="selectlang" name="lang">
                        <?$lang=\app\models\Lang::find()->asArray()->all();if($lang) foreach ($lang as $l) {?>
                            <option value="<?=$l['url']?>" <?if($def_lang==$l['url'])echo "selected";?>><?=$l['name']?></option>
                        <?}?>
                    </select>
                <?}?>
                <?= $form->field($model, 'slug')?>
                <input type="hidden" name="id" id="t-id"/>
            </div>
    </div>
    </div>
 <?}?>
 <br class='clearfix' />
<div class="">
    <?= Html::submitButton(Uni::t('app', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
</div>
<?php Form::end(); ?>
</div>
