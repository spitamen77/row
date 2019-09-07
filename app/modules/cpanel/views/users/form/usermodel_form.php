<?php
/**
* Created by Edoc.uz. 
* User: Rashidov Nuriddin
* I'm a developer not copy paster
* Date: 05.12.2018
* Time: 06:43
*/
?><?php $form = \uni\ui\Form::begin(['id' => 'form_id','options' => ['class' => 'form-horizontal',],'fieldConfig' => [
        'template' => '<div class="row">{label}<div class="col-sm-10">{input}</div><div class="col-sm-10">{error}</div></div>',
        'labelOptions' => ['class' => 'col-sm-2 control-label'],
    ],]);?>
<div class='col-md-6' style='padding: 25px 65px 25px 25px;border-right:2px solid #ccc;'><?=$form->field($model, 'activation_code')->textInput(['maxlength' => 11])?>
<?=$form->field($model, 'email')->input('email');?>
<?=$form->field($model, 'phone')->textInput(['maxlength' => 10])?>
<?=$form->field($model, 'password')->passwordInput(['maxlength' => 255])?>
<?=$form->field($model, 'avatar')->textInput(['maxlength' => 512])?>
<?=$form->field($model, 'username')->textInput(['maxlength' => 32])?>
</div>
<div class='col-md-6'  style='padding:25px;'><?=$form->field($model, 'middlename')->textInput(['maxlength' => 32])?>
<?=$form->field($model, 'lastname')->textInput(['maxlength' => 32])?>
<?=$form->field($model, 'role')->textInput(['maxlength' => 64])?>
<?=$form->field($model, 'firstname')->textInput(['maxlength' => 32])?>
<?=$form->field($model, 'viloyat_id')->input('number')?>
<?=$form->field($model, 'tuman_id')->input('number')?>
<?=$form->field($model, 'id')->hiddenInput()->label(false)?>
</div><div class='col-md-12'><input class="btn btn-blue col-md-6 col-md-offset-3" type="submit" name="usermodel" value="Добавить"></div><?\uni\ui\Form::end() ?>