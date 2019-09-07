<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 13.12.2018 16:21
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */


use app\components\manager\Url;
use app\models\Lang;
use uni\helpers\Html;
use uni\ui\Form;


\app\assets\DashboardAssets::register($this);
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Vaksina.saveVkUchastka();Vaksina.openClearedVkTuman();Vaksina.openVkTumanForm();');

$current = Lang::getCurrent();
if ($current->url=='ru') $name = "name_ru"; else $name = "name_uz";
$viloyat = \app\models\Tuman::findOne($userId);
if (!empty($viloyat->name)) $this->title = $viloyat->name." - ".Uni::t('app','VetControl');
else $this->title = Uni::t('app','VetControl');
//$languages=\app\models\Lang::find()->all();
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}


?>
    <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('users/default/dashboard')?>"><?=Uni::t('app','Back')?></a>
                <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('users/default/viloyat')?>"><?=Uni::t('app','All')?></a>
<!--                <button id="modal_add_VkTuman_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" >--><?//=Uni::t('app','Add')?><!--</button>-->
            </div>
            <div class="uk-width-1-2">
                <form method="get">
                    <div class="uk-grid">
                        <div class="uk-width-3-4">
                            <input class="md-input" placeholder="<?=Uni::t('app','Search')?>" <?=$q?" value='".$q."'":""?> name="q" type="text">
                        </div>
                        <div class="uk-width-1-4">
                            <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content">
            <h2><?=$viloyat->name?></h2>
        </div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover">
                        <thead>
                        <tr>
                            <th><?=Uni::t('app', 'User')?></th>
                            <th><?=Uni::t('app', 'Phone')?></th>
                            <th><?=Uni::t('app', 'Vaccine count')?></th>
                            <th><?=Uni::t('app', 'Vaccine residue')?></th>
                            <!--                        <th>--><?//=Uni::t('app', 'Number')?><!--</th>-->
                            <th>---</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($query)) $data->models = $query->models; ?>
                        <? foreach ($data->models as $value) : ?>
                            <tr>
                                <td><?=$value->username?></td>
                                <td><?=$value->phone?></td>
                                <td><?=$value->summa?></td>
                                <td><?=$value->qoldiq?></td>
                                <!--                            <td>--><?//=$value->uchastka->nomer?><!--</td>-->
                                <td><a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("settings/viloyat/user?sir=$value->id&reg=$viloyat_id&tum=$tuman_id")?>"><?=Uni::t('app', 'More')?></a></td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <? if (!empty($kutish->models)) : ?>
            <div class="md-card-content">
                <h3><?=Uni::t('app', 'In expectation')?></h3>
            </div>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-hover">
                            <thead>
                            <tr>
                                <th><?=Uni::t('app', 'User')?></th>
                                <th><?=Uni::t('app', 'Phone')?></th>
                                <th><?=Uni::t('app', 'Vaccine count')?></th>
                                <!--                            <th>--><?//=Uni::t('app', 'Vaccine residue')?><!--</th>-->
                                <!--                            <th>--><?//=Uni::t('app', 'Number')?><!--</th>-->
                                <th>---</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($query)) $kutish->models = $query->models; ?>
                            <? foreach ($kutish->models as $value) : ?>
                                <tr>
                                    <td><?=$value->username?></td>
                                    <td><?=$value->phone?></td>
                                    <td><?=$value->kutish?></td>
                                    <!--                                <td>--><?//=$value->summa?><!--</td>-->
                                    <!--                                <td>--><?//=$value->uchastka->nomer?><!--</td>-->
                                    <td><a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="javascript:void(0)"><?=Uni::t('app', 'More')?></a></td>
                                </tr>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>



    <!--- Modal New VkVaksina Add -->
    <div class="uk-modal" id="modal_add_VkTuman">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkTuman']); ?>
            <div class="uk-form-row">
                <?= $form->field($m, 'tuman_id')->dropDownList($tuman,['prompt'=>Uni::t("app", "Choose the city"),'tabindex' => 1
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina,['prompt'=>Uni::t("app", "Choose the vaccine"),'tabindex' => 2,
                    'onchange'=>'
                        $.get("/settings/viloyat/listuser",{id: $(this).val()},function(response){
                            $("select#vkuchastka-tum_prixod").html(response);
                        });'
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'tum_prixod')->dropDownList([],['prompt'=>Uni::t("app", "Vaccine number"),'tabindex' => 3
                ])->label(false) ?>
            </div>
            <!--        <div class="uk-form-row">-->
            <!--            --><?//= $form->field($m, 'vaksina_miqdor')->textInput(['tabindex' => 4]) ?>
            <!--        </div>-->
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-2-4">
                    <?= $form->field($m, 'vaksina_miqdor')->textInput() ?>

                </div>
                <div class="uk-width-medium-2-4">
                    <label  class="md-input masked_input"><?=Uni::t('app', 'Unit measure')?> - <b id="prixod-ves"> - </b>, <?=Uni::t('app', 'Dose')?> - <b id="prixod-doza"></b></label>
                    <!--                    <input class="md-input masked_input" id="masked_phone" type="text">-->
                    <input type="hidden" id="prixod-count2" class="md-input" name="Prixod[unit_id]">
                </div>

            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'nomer')->textInput(['tabindex' => 5]) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_date')->textInput(['tabindex' => 6,'data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])->label(Uni::t('app', 'Select date')) ?>
            </div>
            <input type="hidden" id="VkTumanAdd"/>
            <input type="hidden" name="Vktuman[viloyat_id]" value="<?=$userId?>" />
            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveVkTuman']) ?>
            <?php Form::end(); ?>
        </div>
    </div>


    <!--  Modal Notification after adding New VkVaksina -->
    <div class="uk-modal" id="modal_notificationVkTuman">
        <div class="uk-modal-dialog" style="min-height: 400px">
            <button type="button" class="uk-modal-close uk-close"></button>
            <a class="md-btn md-btn-primary" href='<?=Url::to('users/default/tuman')?>'><?=Uni::t('app','Vaksina list')?></a>
            <button class="md-btn md-btn-primary" id='addAnotherVkTuman'><?=Uni::t('app','Add')?></button>
        </div>
    </div>

    <!--  Modal valid Notification after adding New VkVaksina -->
    <div class="uk-modal" id="modal_validVkTuman">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <br>
            <h3>Qiymatni kiritishda xatolik mavjud. kiritilgan qiyman umumiy qoldiq qiymatdan kop miqdorda</h3>
            <br><br>
            <button class="md-btn md-btn-default"><?=Uni::t('app','Close')?></button>
            <button class="md-btn md-btn-primary" id='addAnotherVkTuman'><?=Uni::t('app','Add')?></button>
        </div>
    </div>


    <!---   Modal VkVaksina Edit -->
    <div class="uk-modal" id="modal_edit_VkTuman">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkTumanEdit']); ?>
            <div class="uk-form-row">
                <?= $form->field($m, 'tuman_id')->dropDownList($tuman, ['id' => 'dir-tuman']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina, ['id' => 'dir-vaksina']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_miqdor')->textInput(['id' => 'dir-miqdor']) ?>
            </div>


            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveVkTumanEdit']) ?>
            <?php Form::end(); ?>
        </div>
    </div>

    <!--  Modal VkVaksina after deletion -->
    <div class="uk-modal" id="modal_deleteVkTuman">
        <div class="uk-modal-dialog" style="min-height: 400px">
            <button type="button" class="uk-modal-close uk-close"></button>
            <a class="md-btn md-btn-primary"><?=Uni::t('app','Back to List')?></a>
            <button class="md-btn md-btn-primary" id='deleteAnotherVkTuman'><?=Uni::t('app','Confirm')?></button>
        </div>
    </div>

<?php
$this->registerJs('
    $( "select#vkuchastka-vaksina_id" ).change(function() {
    var x = $(this).val();
    $.get("/settings/viloyat/kg",{id: x},function(response){
         if (response.status=="error")  {
            $("#prixod-ves").html(response.status);
            UIkit.modal.alert("Iltimos vaksinani tanlang!");
         }
         else  {
            $("#prixod-ves").html(response.status);
            $("#prixod-doza").html(response.doza);
            $("#prixod-count2").val(response.val);
            // UIkit.modal.alert($("#prixod-count2").val());
         }        
    });
}); 
');