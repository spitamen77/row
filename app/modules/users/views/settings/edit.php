<?
$lang=\app\models\Lang::getCurrent();
$user=Uni::$app->getUser()->getId();
$companies = Uni::$app->controller->companies;
$sel=[];
if(isset($companies['all'])){
    foreach ($companies['all'] as $company) {
        $sel[$company->company_id]=$company->company->inn." ".$company->company->name;
    }
}

?>
<?php $form = \uni\ui\Form::begin([
    'method' => 'post',
    'id' => 'Edittemplate',
    'fieldConfig' => [
        'template' => '{label}{input}{error}',
                    ],
        ]);
    ?>
    <h3><?=Uni::t('app','Add new template')?></h3>
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-2">
                    <?=$form->field($model, 'company')->dropDownList($sel)?>
                </div>
                <div class="uk-width-1-2">
                    <?=$form->field($model, 'title')->textInput()?>
                </div>
                 <div class="uk-width-1-2">
                    <?=$form->field($model, 'id')->hiddenInput()->label(false)?>
                </div>
                <div class="uk-width-1-1">
                    <?=\app\modules\reference\api\Text::get("template-creation-description")?>
                </div>
                <div class="uk-width-1-1">
                    <?=\app\components\widgets\TinyMce::widget(
                        ['model'=>$model,'attribute'=>'content','clientOptions'=>['language'=>$lang->url,'height'=> "300",'plugins' => [
                            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                            'searchreplace wordcount visualblocks visualchars code fullscreen',
                            'insertdatetime media nonbreaking save table contextmenu directionality',
                            'emoticons template paste textcolor colorpicker textpattern imagetools'
                        ],
                            'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image| print preview media | forecolor backcolor emoticons',]]
                    )?>
               </div>
            </div>
            <div class="uk-grid" >
                <div class="uk-width-medium-1-1">
                    <button id="EditForm" type="submit" class="md-btn md-btn-success md-btn-block"  ><?=Uni::t('app','Save')?></button>
                </div>
            </div>
        </div>
    </div>

<?\uni\ui\Form::end() ?>