<?
$this->registerJs("Muxr.saveUser();");

?>
<div id="page_content_inner">
    <h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Edit profile')?></h3>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <?php $form = \uni\ui\Form::begin(['id' => 'formUser','options' => ['class' => 'form-horizontal',],
                'enableAjaxValidation' => true,
                'validationUrl' => ['/users/profile/validation'],
                'fieldConfig' => [
                    'template' => '{label}{input}{error}',
                ],]);?>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'lastname')->textInput(['maxlength' => 64,])?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'username')->textInput(['maxlength' => 64])?>
                    </div>
                     <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'middlename')->textInput(['maxlength' => 64])?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-3-3">
                        <?=$form->field($model, 'email')->input('email',['maxlength' => 64]);?>
                    </div>
                </div>
            </div>
            <?=$form->field($model, 'id')->hiddenInput()->label(false)?>
            <div class="uk-form-row">
                <button class="md-btn md-btn-success md-btn-block" id="saveUser"><?=Uni::t('app','Save')?></button>
            </div>

            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($info, 'inn')->input('number',['maxlength' => 64,])?>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <?=$form->field($info, 'passport_seria')->textInput(['maxlength' => 2])?>

                    </div>
                    <div class="uk-width-medium-3-6">
                        <?=$form->field($info, 'passport_number')->input('number',['maxlength' => 64,])?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($info, 'passport_gived')->textInput(['maxlength' => 64])?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($info, 'passport_gived_date')->textInput(['maxlength' => 64,'data-uk-datepicker'=>"{format:'DD.MM.YYYY'}"])?>
                    </div>

                    <div class="uk-width-medium-2-6">
                        <?=$form->field($info, 'passport_expired_date')->textInput(['maxlength' => 64,'data-uk-datepicker'=>"{format:'DD.MM.YYYY'}"])?>

                    </div>
                    <div class="uk-width-medium-1-1">
                        <?=$form->field($info, 'address')->textInput(['maxlength' => 64])?>
                    </div>
                </div>
            </div>
            <?\uni\ui\Form::end() ?>
        </div>
    </div>
</div>