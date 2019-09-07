<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 28.11.2018 15:53
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */



use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;

\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveVaksina();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openEditVaksinaForm();Muxr.openDeleteDirectionForm();Muxr.editVaksinaStatus();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}

$this->title = Uni::t('app', 'Vaccine');
?>
<div class="md-card">
    <div class="md-card-content">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formDirection']); ?>
            <div class="uk-form-row">
                <?= $form->field($model, 'vk_turi')->dropDownList($vaksinaTuri,['prompt'=>Uni::t("app", "Choose the vaccine type"),'tabindex' => 1])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($model, 'name_ru')->textInput() ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($model, 'name_uz')->textInput() ?>
            </div>

            <div class="uk-form-row">
                <?= $form->field($model, 'unit_id')->dropDownList($unit) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($model, 'doza')->textInput() ?>
            </div>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-4">
                    <?= $form->field($model, 'mol')->textInput() ?>

                </div>
                <div class="uk-width-medium-1-4">
                    <?= $form->field($model, 'qoy')->textInput() ?>

                </div>
                <div class="uk-width-medium-1-4">
                    <?= $form->field($model, 'tovuq')->textInput() ?>

                </div>
                <div class="uk-width-medium-1-4">
                    <?= $form->field($model, 'mushuk')->textInput() ?>

                </div>

            </div>
            <input type="hidden" id="directionAdd"/>
            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveDirection']) ?>
            <?php Form::end(); ?>
        </div>
    </div>