<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 22.01.2019 12:54
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;

\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.savePreparat();Muxr.dynamicFields();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openEditVaksinaForm();Muxr.openDeleteDirectionForm();Muxr.editVaksinaStatus();');


$current = Lang::getCurrent();

if ($current->url=="ru") $map = ArrayHelper::map($items,'id','name_ru');
else $map = ArrayHelper::map($items,'id','name_uz');

if ($current->url=="ru") $map2 = ArrayHelper::map($hayvon,'id','name_ru');
else $map2 = ArrayHelper::map($hayvon,'id','name_uz');

$this->title = Uni::t('app', 'Edit vaccine').' - '.$new->name;
?>
<h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Edit vaccine')?></h3>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
        </div>
    </div>
</div>

<!--<div id="page_content_inner">-->

    <div class="md-card">
        <div class="md-card-content large-padding">
<!--            --><?php //$form = Form::begin(['id'=>'formCon', 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <?php $form = Form::begin(['id' => 'formUchastka','options' => ['enctype' => 'multipart/form-data'],

                'fieldConfig' => [
                    'template' => '{label}{input}{error}',
                ],]);?>

            <hr class="md-hr">
            <br>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <?= $form->field($new, 'vk_turi')->dropDownList($map,['prompt'=>Uni::t("app", "Choose the vaccine type"),'tabindex' => 1])->label(false) ?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($new, 'name_ru')->textInput(['tabindex' => 2])?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($new, 'name_uz')->textInput(['tabindex' => 3])?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'category_id')->dropDownList($map2,['tabindex' => 4])->label(false);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($new, 'unit_id')->dropDownList($unit,['tabindex' => 5]) ?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($new, 'doza')->textInput(['tabindex' => 6]);?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($animal, 'temperatura')->textInput(['tabindex' => 7]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <label class="control-label" for="emlash_turi"><?=Uni::t('app', 'emlama')?></label>
                        <select id="emlash_turi" class="md-input" required name="emlash_turi" tabindex ="8">
                            <option value="0"><?=Uni::t('app', 'Profilaktik')?></option>
                            <option value="1"><?=Uni::t('app', 'Required')?></option>
                        </select>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'emlash_vaqti')->textInput(['tabindex' => 9]);?>
                    </div>
                </div>

            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($animal, 'emlash_hududi')->textInput(['tabindex' => 10]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'hayvon_turi_yoshi')->textInput(['tabindex' => 11]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'emlash_uchun')->textInput(['tabindex' => 12]);?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($animal, 'emlash_davri')->textInput(['tabindex' => 13]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'revaksinatsiya')->textInput(['tabindex' => 14]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'immunitet')->textInput(['tabindex' => 15]);?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($animal, 'talab_cheklash')->textarea(['tabindex' => 16]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($animal, 'laboratoriya_diagnos')->textarea(['tabindex' => 17]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($new, 'file')->fileInput(['tabindex' => 18]) ?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <button type="submit" class="md-btn md-btn-success md-btn-block" id="saveUser" tabindex ="19"><?=Uni::t('app','Save')?></button>
            </div>
            <?php Form::end() ?>
        </div>
    </div>
<!--shu yer-->
