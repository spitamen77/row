<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 10.12.2018 12:30
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
use uni\widgets\Pjax;

\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.savePrixod();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openEditArrivalForm();Muxr.editPrixodStatus();Vaksina.openDistribution();Vaksina.saveDistribution();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Arrival');

$m = new \app\models\VkViloyat;
$prixod = [];

$this->registerJs("
function bindFilterForm(){
$('#filterForm :input').on('change',function(){
    $(this).closest('form').submit(function () {
    $(this)
        .find('input[name]')
        .filter(function () {
            return !this.value;
        })
        .prop('name', '');
        return true;
});

$(this).submit();
});
}
bindFilterForm();
 $('#filterData').on('pjax:end', function() {
        $.pjax.reload({container:'#listData'});
        bindFilterForm();
    });
");
?>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-2-10">
                <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button>
            </div>
            <div class="uk-width-medium-8-10">
                <?Pjax::begin(['id'=>'filterData'])?>
                <?Form::begin(['id'=>'filterForm','method'=>'get','action'=>Url::getMain(),'options' => ['class' => '', 'data-pjax' => true]])?>
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-3-10">
                            <label for="product_search_name"><?=Uni::t('app',"Arrival name")?></label>
                            <input name="name" type="text" class="md-input" id="product_search_name">
                        </div>
                        <div class="uk-width-medium-2-10">
                            <div class="uk-margin-small-top">
                                <select name="unit_id" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?=Uni::t('app',"Unit")?></option>
                                    <? foreach (\app\models\Unit::find()->all() as $v) { ?>
                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-3-10">
                            <div class="uk-margin-small-top">
                                <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?=Uni::t('app',"Vaccine category")?></option>
                                    <? foreach (\app\models\Vaksina::find()->all() as $v) { ?>

                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-2-10 uk-text-center">
                            <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                        </div>
                    </div>
                <? Form::end()?>
                <? Pjax::end()?>
            </div>
        </div>
    </div>
</div>


<?Pjax::begin(['id'=>'listData'])?>
<div class="md-card">
    <div class="md-card-content">
        <table class="uk-table uk-table-nowrap uk-table-hover table_check">
            <thead>

            <tr>
                <th class="uk-width-1-10 uk-text-center small_col">№</th>

                <th class="uk-width-2-10"><?= Uni::t('app', 'Arrival name') ?></th>
                <!-- <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Arrival number') ?></th> -->
                <!-- <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Created') ?></th> -->
                <th class="uk-width-2-10 uk-text-left"><?= Uni::t('app', 'Vaccine') ?></th>
                <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Count') ?></th>
                <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'The remainder') ?></th>
                <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'FIO') ?></th>
                <!-- <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th> -->
                <? //= Uni::t('app', 'Phone') ?><!--</th>-->
                <!--                <th class="uk-width-1-10 uk-text-center">-->
                <? //= Uni::t('app', 'Status') ?><!--</th>-->
                <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($items->models)): ?>
                <?php $i=0; foreach ($items->models as $model) {$i++; $prixod[$model->id]=($model->name)?$model->name:Yii::t('app',"Not set");?>
                    <tr id='row_<?=$model->id?>'>
                        <? $st = $model->status; ?>
                        <td class="uk-text-center uk-table-middle small_col">
                            <?=$i?>
                        </td>
                        <td class="uk-width-2-10"><?= ($model->name)?$model->name:Yii::t('app',"Not set") ?></td>
                        <!-- <td class="uk-width-2-10 uk-text-center"><?=$model->number?></td> -->
                       <!--  <td class="uk-width-1-10 uk-text-center"><?=date('d-m-Y', $model->prixod_date)?></td> -->
                        <td class="uk-width-2-10 uk-text-left"><?=$model->vaksina->name?></td>
                        <td class="uk-width-1-10 uk-text-center"><?=$model->count?>-<?=$model->vaksina->unit->name?></td>
                        <td class="uk-width-1-10 uk-text-center"><?=$model->ostatok?>-<?=$model->vaksina->unit->name?></td>
                        <td class="uk-width-1-10 uk-text-center"><?=$model->user->makeFIO()?></td>
                        <!-- <td class="uk-width-1-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>">
                                <i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i>
                            </a>
                        </td> -->
                        <td class="uk-text-center">
                            <a class="modal-edit-direction" data-id="<?=$model->id?>" data-title="<?=$model->name_ru?>" data-short="<?=$model->name_uz?>"
                               data-value="<?=$model->vaksina_id?>" data-count="<?=$model->count?>" data-number="<?=$model->number?>">
                                <i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            <a type="button" href="<?=Url::to('settings/arrival/prixod/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                            <!-- <a class="modal-delete-direction" type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_delete'}"><i
                                    class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a> -->
                            <a class="model-distribution modal_distribution_VkViloyat_btn" data-vaksina="<?=$model->vaksina->id?>" data-prixod="<?=$model->id?>" data-uk-modal="{bgClose:true;modal:true}" ><i class="md-icon material-icons uk-text-primary">add_circle</i></a>

                        </td>
                    </tr>
                <? } ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<?= uni\widgets\LinkPager::widget([
    'pagination' => $items->pagination,
    'options'=>['class' => 'uk-pagination']
]) ?>
<? Pjax::end()?>
    <!--- Modal New Direction Add -->
    <div class="uk-modal" id="modal_add_direction">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formDirection']); ?>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_ru')->textInput() ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_uz')->textInput() ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'vaksina_id')->dropDownList($vaksina,['prompt'=>Uni::t("app", "Choose the vaccine"),'tabindex' => 2])->label(false) ?>
            </div>

            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-4">
                    <?= $form->field($new, 'count')->textInput() ?>

                </div>
                <div class="uk-width-medium-2-4">
                    <label  class="md-input masked_input"><?=Uni::t('app', 'Unit measure')?> - <b id="prixod-ves"> - </b>, <?=Uni::t('app', 'Dose')?> - <b id="prixod-doza"></b></label>
<!--                    <input class="md-input masked_input" id="masked_phone" type="text">-->
                    <input type="hidden" id="prixod-count2" class="md-input" name="Prixod[unit_id]">
                </div>

            </div>

            <div class="uk-form-row">
                <?= $form->field($new, 'number')->textInput() ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'prixod_date')->textInput(['tabindex' => 5,'data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}', 'value' => date("d.m.Y"),])->label(Uni::t('app', 'Select date')) ?>
            </div>
            <!--            <input type="hidden" id="directionAdd"/>-->
            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveDirection']) ?>
            <?php Form::end(); ?>
        </div>
    </div>



    <!---   Modal Direction View -->
    <div class="uk-modal" id="modal_view" aria-hidden="true" style="display: none; overflow-y: scroll;">
        <div class="uk-modal-dialog" style="top: 34.5px;">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title"><?= Uni::t('app', 'Arrival') ?></h3>
            </div>
            <table class="uk-table uk-table-hover uk-table-bordered">
                    <thead>
                    <tr>
                        <th><?=Uni::t('app', 'Name ru')?></th>
                        <th><?=Uni::t('app', 'Name uz')?></th>
                        <th><?=Uni::t('app', 'Vaccine')?></th>
                        <th><?=Uni::t('app', 'Count')?></th>
                        <th><?=Uni::t('app', 'Unit')?></th>
                    </tr>
                    </thead>
                <tbody>
                <tr>
                    <td id="modal_view_text"></td>
                    <td id="modal_view_text2"></td>
                    <td id="modal_view_vaksina"></td>
                    <td id="modal_view_count"></td>
                    <td id="modal_view_unit"></td>
                </tr>
                </tbody>
            </table>
            <p id="modal_view_text2">.</p>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close"><?= Uni::t('app', 'Close') ?></button>
            </div>
        </div>
    </div>

    <!--  Modal Direction after deletion -->
    <div class="uk-modal" id="modal_deleteDirection">
        <div class="uk-modal-dialog" style="min-height: 400px">
            <button type="button" class="uk-modal-close uk-close"></button>
            <a class="md-btn md-btn-primary"><?=Uni::t('app','Back to List')?></a>
            <button class="md-btn md-btn-primary" id='deleteAnotherDirection'><?=Uni::t('app','Confirm')?></button>
        </div>
    </div>

    <!-- Modal Direction edit -->
    <div class="uk-modal" id="modal_edit_direction">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formDirectionEdit']); ?>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_ru')->textInput(['id' => 'dir-title'])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_uz')->textInput(['id' => 'dir-short'])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'number')->textInput(['id' => 'dir-number'])->label(false) ?>
            </div>
<!--            <div class="uk-form-row">-->
<!--                --><?//= $form->field($new, 'name_uz')->textInput(['id' => 'dir-short']) ?>
<!--            </div>-->
            <div class="uk-form-row">
                <?= $form->field($new, 'vaksina_id')->dropDownList($vaksina,['prompt'=>Uni::t("app", "Choose the vaccine"),'tabindex' => 2, 'id'=>'dir-value'])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'count')->textInput(['id' => 'dir-count'])->label(false) ?>
            </div>
            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveDirectionEdit']) ?>
            <?php Form::end(); ?>
        </div>
    </div>



    <!--- Modal New VkVaksina Add -->
<div class="uk-modal" id="modal_distribution_VkViloyat">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkViloyat']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'viloyat_id')->dropDownList($viloyat,['prompt'=>Uni::t("app", "Choose the region"),'tabindex' => 1
                    ])->label(false) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina,['id' => 'dir-vaksina', 'disabled' => true])->label(false) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'proxod_id')->dropDownList($prixod,['id' => 'dir-prixod','disabled' => true])->label(false) ?>
                </div>
<!--                <div class="uk-form-row">-->
<!--                    --><?//= $form->field($m, 'vaksina_miqdor')->textInput(['tabindex' => 4]) ?>
<!--                </div>-->
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-2-4">
                        <?= $form->field($m, 'vaksina_miqdor')->textInput() ?>

                    </div>
                    <div class="uk-width-medium-2-4">
                        <label  class="md-input masked_input"><?=Uni::t('app', 'Unit measure')?> - <b id="prixod-ves11"> - </b>, <?=Uni::t('app', 'Dose')?> - <b id="prixod-doza11"></b></label>
                        <!--                    <input class="md-input masked_input" id="masked_phone" type="text">-->
                        <input type="hidden" id="vaksina_id211" class="md-input" name="VkViloyat[vaksina_id]">
                        <input type="hidden" id="proxod_id211" class="md-input" name="VkViloyat[proxod_id]">

                        <input type="hidden" id="prixod-count211" class="md-input" name="Prixod[unit_id]">

                    </div>

                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'nomer')->textInput(['tabindex' => 5]) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'proxod_date')->textInput(['tabindex' => 6,'data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])->label(Uni::t('app', 'Select date')) ?>
                </div>
                <input type="hidden" id="VkViloyatAdd"/>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveVkViloyat']) ?>
        <?php Form::end(); ?>
    </div>
</div>



<?php
$this->registerJs(' /*ko`rish oynasi*/
    $("i.eye").click(function(e){
        //e.preventDefault();
        var model= $(this).parent().attr("data-id");
        $.get("../arrival/view",{id: model},function(response){
            if(response!="error"){
                $("#modal_view_text").html(response.name_ru);
                $("#modal_view_text2").html(response.name_uz);
                $("#modal_view_vaksina").html(response.vaksina);
                $("#modal_view_unit").html(response.unit);
                $("#modal_view_count").html(response.count);
            }
            else {
                $("#modal_view_text").html(response);
                $("#modal_view_text2").html(response);
            }
        });
    });

     $(\'.modal-delete-direction\').click(function(){
        var pk=$(this).attr("data-id");
        var url=\'../arrival/delete/\'+pk;
        swal({
                title: "'.Uni::t('app', 'Are you sure?').'",
                text: "'.Uni::t("app", "You will not be able to recover this information").'!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "'.Uni::t("app", "Delete").'!",
                cancelButtonText: "'.Uni::t("app", "Cancel").'",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("'.Uni::t("app", "Deleted").'!", "'.Uni::t("app", "Information deleted").'.", "success");
                    }else{
                        swal("'.Uni::t("app", "Not deleted").'!", "'.Uni::t("app", "The information is not deleted").'.", "error");
                    }
                });
            });
    });
');

$this->registerJs('
$("#prixod-count").focusout(function () {
            var value = $(this).val();
            value = Number(value);
            console.log(value);
            if (isNaN(value)) {
                UIkit.modal.alert("Faqat butun son kiriting");
            }
        });
        
$( "select" ).change(function() {
    var x = $(this).val();
    $.get("../arrival/kg",{id: x},function(response){
         if (response.status=="error")  {
            $("#prixod-ves").html(response.status);
            UIkit.modal.alert("Iltimos vaksinani tanlang!");
         }
         else  {
            $("#prixod-ves").html(response.status);
            $("#prixod-doza").html(response.doza);
            $("#prixod-count2").val(response.val);
           
         }        
    });
});        
if($("#dir-prixod :selected").val()!="undefined"){
    var x = $("#dir-prixod :selected").val(), tx = $("#dir-prixod :selected").text();
    $.get("../arrival/kg",{id: x},function(response){
         if (response.status=="error")  {
            $("#dir-prixod").html(tx+" ( "+response.status+")");
        }
         else  {
            
            console.log("bomadiku");
         }        
    });
}
      ');

?>
