<?


use app\components\manager\Url;
use app\models\Lang;
use uni\helpers\Html;
use uni\ui\Form;


// \app\assets\DashboardAssets::register($this);
// \app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Vaksina.saveVkUchastka();Vaksina.openClearedVkTuman();Vaksina.openVkTumanForm();');

$current = Lang::getCurrent();
if ($current->url=='ru') $name = "name_ru"; else $name = "name_uz";
$viloyat = \app\models\Tuman::findOne($userId);
if (!empty($viloyat->name)) $this->title = $viloyat->name." - ".Uni::t('app','VetControl');
else $this->title = Uni::t('app','VetControl');
//$languages=\app\models\Lang::find()->all();
$q=false;
$user = Uni::$app->getUser()->identity;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}


?>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-2-10">
                <button id="modal_add_VkTuman_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-primary uk-margin-small-top" ><?=Uni::t('app','Add')?></button>

            </div>
            <div class="uk-width-medium-8-10">
                <form method="get">
                    <div class="uk-grid" data-uk-grid-margin="">
                         <div class="uk-width-medium-3-10">
                            <div class="uk-margin-small-top">
                                <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?=Uni::t('app',"Hudud category")?></option>
                                    <? foreach (\app\models\Uchastka::find()->where(['tuman_id'=>$user->personal->tuman_id])->all() as $v) { ?>

                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-3-10">
                            <label for="product_search_name"><?=Uni::t('app',"Vaccene name")?></label>
                            <input name="name" type="text" class="md-input" id="product_search_name">
                        </div>
                        <div class="uk-width-medium-2-10">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                <label for="uk_dp_1"><?=Uni::t('app',"Select date")?></label>
                                <input class="md-input" type="text" id="uk_dp_1" data-uk-datepicker="{format:'DD.MM.YYYY'}">
                            </div>
                        </div>
                        <div class="uk-width-medium-2-10 uk-text-center">
                            <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('users/default/dashboard')?>"><?=Uni::t('app','Back')?></a>
            <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('users/default/viloyat')?>"><?=Uni::t('app','All')?></a>
            <button id="modal_add_VkTuman_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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
</div> -->
<div class="md-card">
    <div class="md-card-content">
        <h2><?=Uni::t('app', 'Administration panel')?></h2>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover">
                    <thead>
                    <tr>
                        <th><?=Uni::t('app', 'Town')?></th>
                        <th><?=Uni::t('app', 'Vaccine')?></th>
                        <th><?=Uni::t('app', 'Vaccine count')?></th>
                        <th><?=Uni::t('app', 'Vaccine residue')?></th>
                        <th><?=Uni::t('app', 'Status')?></th>
                        <th><?=Uni::t('app', 'Created date')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($data->models as $value) : $st = $value->status; ?>
                        <tr>
                            <td><?=($value->hudud)?$value->hudud->name:Uni::t("app","User not found")?></td>
                            <td><?=$value->vaksina->name?></td>
                            <td><?=$value->vaksina_miqdor?> - <?=$value->vaksina->unit->name?></td>
                            <td><?=$value->ostatok?> - <?=$value->vaksina->unit->name?></td>
                            <td><?if($st==0)echo Uni::t("app","Not seen"); elseif($st==1)echo Uni::t("app","Accepted"); elseif($st==2)echo Uni::t("app","Denied"); elseif($st==3)echo Uni::t("app","Closed")?></td>
                            <td><?=date("d-m-Y",$value->vaksina_date)?></td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 


<!--- Modal New VkVaksina Add -->
<div class="uk-modal" id="modal_add_VkTuman">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkTuman']); ?>
        <div class="uk-form-row">
            <?= $form->field($m, 'uchastka_id')->dropDownList($tuman,['prompt'=>Uni::t("app", "Choose the town"),'tabindex' => 1
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