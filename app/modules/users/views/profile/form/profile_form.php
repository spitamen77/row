<?php
/**
* Created by Edoc.uz. 
* User: Rashidov Nuriddin
* I'm a developer not copy paster
* Date: 08.10.2017
* Time: 21:09
*/
?>
<br>
<br>
<div class="container">
<?php $form = \uni\ui\Form::begin(['id' => 'form_id','options' => ['enctype'=>'multipart/form-data']]);?>
<?=$form->field($model, 'avatar')->widget(\kartik\file\FileInput::classname(), ['options' => ['accept' => 'image/*'],]);?>
<?=$form->field($model, 'username')->textInput(['maxlength' => 250])?>
<?=$form->field($model, 'middlename')->textInput(['maxlength' => 512])?>
<?=$form->field($model, 'lastname')->textInput(['maxlength' => 512])?>
<?=$form->field($model, 'phone')->textInput(['maxlength' => 512])?>
<?=$form->field($model, 'email')->textInput(['maxlength' => 512])?>
<input class="btn btn-default" type="submit" name="video" value="Save Profil Info">
<?\uni\ui\Form::end() ?>
</div>