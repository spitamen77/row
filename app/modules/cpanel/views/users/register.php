<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 05.12.2018 10:50
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */
use app\assets\CoreAssets;
use uni\widgets\Form;
use uni\helpers\Html;
use uni\helpers\Url;
//use yii\bootstrap\ActiveForm;
$this->title = Uni::t('app', 'Control panel')." | ". Uni::t('app', 'Add new user');
$this->registerJsFile('/../../themes/ui/components/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/assets/js/pages/forms_advanced.js', ['depends' => [CoreAssets::className()]]);




$uchastka = [];

foreach (\app\models\Viloyat::find()->where(['status'=>\app\models\Viloyat::STATUS_ACTIVE])->all() as $v) {
    $viloyat[$v->id] = $v->name_uz;
}
if(Uni::$app->controller->access('ADMIN_VIL')){
    foreach (\app\models\Tuman::find()->where(['status'=>\app\models\Tuman::STATUS_ACTIVE,'viloyat_id'=>$user->personal->viloyat_id])->all() as $v) {
        $tuman[$v->id] = $v->name_uz;
    }
}

if(Uni::$app->controller->access('ADMIN_TUM')){
    $v = Viloyat::findOne($user->personal->viloyat_id);
    $viloyat[$v->id] = $v->name_uz;
    $t = Tuman::findOne($user->personal->tuman_id);
    $tuman[$t->id] = $t->name_uz;
    foreach (Uchastka::find()->where(['status'=>Uchastka::STATUS_ACTIVE,'tuman_id'=>$user->personal->tuman_id])->all() as $v) {
        $uchastka[$v->id] = $v->name_uz;
    }
}




?>
<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("../users/index")?>"><?=Uni::t('app','Back')?></a>
<p></p>
<div class="uk-width-large-6-10 uk-row-first" style="min-height: 1809px;">
    <div class="md-card">
        <button type="button" class="uk-position-top-right uk-close " style="display: none"></button>
        <div class="md-card-content large-padding" id="register_form" style="display: block">
    
    <?php $form = Form::begin([
        'options' => [
            'class' => 'form-signin cform',
        ],
    ]); ?>
        <!-- <div class="uk-form-row">
            <?#= $form->field($model, 'username')->textInput(['autofocus' => true, 'required' => 'required', 'class'=>'md-input','tabindex' => 1]) ?>
        </div> -->
        <h2 class="heading_a uk-margin-medium-bottom"><?=Uni::t('app', 'Personal information')?></h2>
        <!-- <div class="uk-form-row">
            <?= $form->field($model, 'lastname')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 1]) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($model, 'firstname')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 2]) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($model, 'middlename')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 3]) ?>
        </div> -->
        <!-- <div class="uk-form-row">
            <?= $form->field($model, 'phone')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 4]) ?>
        </div> -->
<!--        <div class="uk-form-row">-->
<!--            --><?//= $form->field($model, 'lastname')->textInput([ 'class'=>'md-input','tabindex' => 1]) ?>
<!--        </div>-->
<!--        <div class="uk-form-row">-->
<!--            --><?//= $form->field($model, 'firstname')->textInput([ 'class'=>'md-input','tabindex' => 2]) ?>
<!--        </div>-->
<!--        <div class="uk-form-row">-->
<!--            --><?//= $form->field($model, 'middlename')->textInput([ 'class'=>'md-input','tabindex' => 3]) ?>
<!--        </div>-->
        <div class="uk-form-row">
            <?= $form->field($model, 'phone')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 4]) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($model, 'email')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 5]) ?>
        </div>

        <div class="uk-form-row">
            <?= $form->field($model, 'viloyat_id')->dropDownList($items,['prompt'=>Uni::t("app", "Select region"),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 6,
                'onchange'=>'
                    $.get("/cpanel/users/list",{id: $(this).val()},function(response){
                        $("select#usermodel-tuman_id").html(response);
                    });'
                ])->label(false) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($model, 'tuman_id')->dropDownList([],['prompt'=>Uni::t('app', 'Choose the city'),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 7,
                'onchange'=>'
                    $.get("/cpanel/users/hududlist",{id: $(this).val()},function(response){
                        $("select#usermodel-hudud").html(response);
                    });'
            ])->label(false) ?>
        </div>


        <br>
        <h2 class="heading_a uk-margin-medium-bottom"><?=Uni::t('app', 'Account information')?></h2>
        <hr>
        <div class="uk-form-row">
            <?= $form->field($model, 'email')->textInput(['required' => 'required', 'class'=>'md-input','tabindex' => 7]) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($model, 'password')->passwordInput(['required' => 'required', 'class'=>'md-input','tabindex' => 8]) ?>

        <div class="uk-form-row">
            <?=$form->field($model, 'hudud')->dropDownList([], ['class'=>'md-input','data-uk-tooltip'=>'{pos:\'top\'}','prompt'=>Uni::t('app', 'Hudud'),'tabindex' => 8,])->label(false);?>

        </div>
<!--        <br>-->
<!--        <h2 class="heading_a uk-margin-medium-bottom">--><?//=Uni::t('app', 'Account information')?><!--</h2>-->
<!--        <hr>-->
            <div class="uk-form-row">
                <?= $form->field($model, 'role')->dropDownList($group,['required' => 'required','prompt'=>Uni::t("app", "Select group"),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 9
                ])->label(false) ?>
            </div>

        <div class="uk-form-row">
            <?= $form->field($model, 'password')->passwordInput(['required' => 'required', 'class'=>'md-input','tabindex' => 10]) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($model, 'rpassword')->passwordInput(['required' => 'required', 'class'=>'md-input','tabindex' => 11]) ?>
        </div>

        
        <div class="uk-margin-medium-top">
            <button href="index.html" class="md-btn md-btn-primary md-btn-block md-btn-large" tabindex="12"><?=Uni::t('app', 'Save')?></button>
        </div>

    <?php Form::end(); ?>
</div>