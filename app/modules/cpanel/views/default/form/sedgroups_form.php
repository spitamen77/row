<?php
/**
* Created by Muxr.uz.
* User: Rashidov Nuriddin
* I'm a developer not copy paster
* Date: 13.10.2015
* Time: 08:35
*/
?><?php $form = \uni\ui\Form::begin(['id' => 'form_id','options' => ['class' => 'form-horizontal',],'fieldConfig' => [
        'template' => '<div class="row">{label}<div class="col-sm-10">{input}</div><div class="col-sm-10">{error}</div></div>',
        'labelOptions' => ['class' => 'col-sm-2 control-label'],
    ],]);?>
<div class='col-md-6' style='padding: 25px 65px 25px 25px;border-right:2px solid #ccc;'><?=$form->field($model, 'group')->textInput(['maxlength' => 200])?>
</div>
<div class='col-md-6'  style='padding:25px;'><?=$form->field($model, 'title')->textInput(['maxlength' => 200])?>
<?=$form->field($model, 'active')->widget(kartik\widgets\Select2::classname(),['language' => 'ru','data' => \app\models\Groups::getDropDownActive(),'options' => ['multiple' => false,'placeholder' => 'Select  ...'],'pluginOptions' => ['allowClear' => true ],]);?>
</div><?\uni\ui\Form::end() ?>