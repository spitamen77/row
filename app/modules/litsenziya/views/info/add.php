<?
$this->registerJs("Muxr.saveUserInfo();");

?>
<div id="page_content_inner">
    <h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Add extra information about you')?></h3>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <?php $form = \uni\ui\Form::begin(['id' => 'formUserInfo','options' => ['class' => 'form-horizontal',],
                'enableAjaxValidation' => true,
                'validationUrl' => ['/users/info/validation'],
                'fieldConfig' => [
                    'template' => '{label}{input}{error}',
                ],]);?>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($model, 'inn')->input('number',['maxlength' => 64,])?>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <?=$form->field($model, 'passport_seria')->textInput(['maxlength' => 2])?>

                    </div>
                    <div class="uk-width-medium-3-6">
                        <?=$form->field($model, 'passport_number')->input('number',['maxlength' => 64,])?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($model, 'passport_gived')->textInput(['maxlength' => 64])?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($model, 'passport_gived_date')->textInput(['maxlength' => 64,'data-uk-datepicker'=>"{format:'DD.MM.YYYY'}"])?>
                    </div>

                    <div class="uk-width-medium-2-6">
                        <?=$form->field($model, 'passport_expired_date')->textInput(['maxlength' => 64,'data-uk-datepicker'=>"{format:'DD.MM.YYYY'}"])?>

                    </div>
                    <div class="uk-width-medium-1-1">
                        <?=$form->field($model, 'address')->textInput(['maxlength' => 64])?>
                    </div>
                </div>
            </div>
            <br/>
            <?=$form->field($model, 'id')->hiddenInput()->label(false)?>
            <?=$form->field($model, 'user_id')->hiddenInput(['value'=>$user->id])->label(false)?>
            <div class="uk-form-row">
                <button type="button" class="md-btn md-btn-success md-btn-block" id="saveUserInfo"><?=Uni::t('app','Save')?></button>
            </div>
            <?\uni\ui\Form::end() ?>
        </div>
    </div>
</div>