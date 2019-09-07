<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 17.12.2018 12:45
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.savePrixod();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openEditArrivalForm();Muxr.editPrixodStatus();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Vaccine')." | ".Uni::t('app', 'Arrival');
?>
    <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
                <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('vaksinatsiya/default/all')?>"><?=Uni::t('app','All')?></a>
                <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button>
            </div>
            <div class="uk-width-1-2">
                <form method="get">
                    <div class="uk-grid">
                        <div class="uk-width-3-4">
                            <input class="md-input" placeholder="<?=Uni::t('app', 'Search')?>..." <?=$q?" value='".$q."'":""?> name="q" type="text">
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
            <table  class="uk-table uk-table-hover">
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
                <?php if (!empty($query)) $items->models = $query->models; ?>
                <?php if (!empty($items->models)): ?>
                    <?php $i=0; foreach ($items->models as $model) {$i++; ?>
                        <tr id='row_<?=$model->id?>'>
                            <? $st = $model->status; ?>
                            <td class="uk-text-center  small_col">
                                <?=$i;?>
                            </td>
                            <td class="uk-width-2-10"><?= ($model->name)?$model->name:Yii::t('app',"Not set") ?></td>
                            <!-- <td class="uk-width-2-10 uk-text-center"><?=$model->number?></td> -->
                            <!--  <td class="uk-width-1-10 uk-text-center"><?=date('d-m-Y', $model->prixod_date)?></td> -->
                            <td class="uk-width-2-10 uk-text-left"><?=$model->vaksina->name?></td>
                            <td class="uk-width-1-10 uk-text-center"><?=$model->count?></td>
                            <td class="uk-width-1-10 uk-text-center"><?=$model->ostatok?></td>
                            <td class="uk-width-1-10 uk-text-center"><?=$model->user->makeFIO()?></td>
                            <!-- <td class="uk-width-1-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>">
                                    <i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i>
                                </a>
                            </td> -->
                            <td class="uk-text-center">
                                <!-- <a class="modal-edit-direction" data-id="<?=$model->id?>" data-title="<?=$model->name_ru?>" data-short="<?=$model->name_uz?>"
                                   data-value="<?=$model->vaksina_id?>" data-count="<?=$model->count?>" data-number="<?=$model->number?>">
                                    <i class="md-icon material-icons uk-text-primary">&#xE254;</i></a> -->
                                <a type="button" href="<?=Url::to('settings/arrival/prixod/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                                <!-- <a class="modal-delete-direction" type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_delete'}"><i
                                        class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a> -->
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
                <?= $form->field($new, 'prixod_date')->textInput(['tabindex' => 5,'data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])->label(Uni::t('app', 'Select date')) ?>
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
<?php
$this->registerJs(' /*ko`rish oynasi*/
    $("i.eye").click(function(e){
        //e.preventDefault();
        var model= $(this).parent().attr("data-id");
        $.get("../vaksina/view",{id: model},function(response){
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
    $.get("/reference/viloyat/kg",{id: x},function(response){
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

?>