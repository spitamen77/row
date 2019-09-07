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


use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveVaksina();Muxr.dynamicFields();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openEditVaksinaForm();Muxr.openDeleteDirectionForm();Muxr.editVaksinaStatus();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
if ($current->url=="ru") $map = ArrayHelper::map($items,'id','name_ru');
else $map = ArrayHelper::map($items,'id','name_uz');
$this->title = Uni::t('app', 'Vaccine');
?>
<!--    <div class="block-process" style="margin-bottom:10px;">-->
<!--        <div class="uk-grid">-->
<!--            <div class="uk-width-1-2">-->
<!--                <a class="md-btn md-btn-success md-btn-small" href="--><?//=Url::to('settings/vaksina/index')?><!--">--><?//=Uni::t('app','All')?><!--</a>-->
<!--                <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" >--><?//=Uni::t('app', 'Add vaccine')?><!--</button>-->
<!--                <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">-->
<!--                    <button class="md-btn md-btn-block md-btn-small">--><?//=Uni::t('app', 'Drug types')?><!-- <i class="material-icons"></i></button>-->
<!--                    <div class="uk-dropdown">-->
<!--                        <ul class="uk-nav uk-nav-dropdown">-->
<!--                            <li><a href="--><?//=Url::to('settings/vaksina/index')?><!--" class="viloyat">--><?//= Uni::t('app',"All") ?><!--</a></li>-->
<!--                            --><?php //foreach ($items as $item): ?>
<!--                                <li><a href="--><?//=Url::to('settings/vaksina/index?slug=item&drug='.$item->id)?><!--" class="viloyat" data-id="--><?//=$item->id?><!--">--><?//= ($item->name)?$item->name:Uni::t('app',"Not set") ?><!--</a></li>-->
<!--                            --><?php //endforeach; ?>
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="uk-width-1-2">-->
<!--                <form method="get">-->
<!--                    <div class="uk-grid">-->
<!--                        <div class="uk-width-3-4">-->
<!--                            <input class="md-input" placeholder="--><?//=Uni::t('app', 'Search')?><!--..." --><?//=$q?" value='".$q."'":""?><!-- name="q" type="text">-->
<!--                        </div>-->
<!--                        <div class="uk-width-1-4">-->
<!--                            <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="md-card">
        <div class="md-card-content">
<!--            <a class="md-btn md-btn-success md-btn-small" href="--><?//=Url::to('settings/vaksina/index')?><!--">--><?//=Uni::t('app','All')?><!--</a>-->
            <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add vaccine')?></button>
            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                <button class="md-btn md-btn-block md-btn-small"><?=Uni::t('app', 'Drug types')?> <i class="material-icons"></i></button>
                <div class="uk-dropdown">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li><a href="<?=Url::to('settings/vaksina/index')?>" class="viloyat"><?= Uni::t('app',"All") ?></a></li>
                        <?php foreach ($items as $item): ?>
                            <li><a href="<?=Url::to('settings/vaksina/index?slug=item&drug='.$item->id)?>" class="viloyat" data-id="<?=$item->id?>"><?= ($item->name)?$item->name:Uni::t('app',"Not set") ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <form method="get">
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-3-10">
                        <a class="md-btn md-btn-warning uk-margin-small-top" href="<?=Url::to('settings/vaksina/index')?>"><?=Uni::t('app','All')?></a>
                    </div>
                    <div class="uk-width-medium-2-10">
                        <label for="product_search_name"><?=Uni::t('app',"Drug name")?></label>
                        <input name="name" type="text" class="md-input" id="product_search_name">
                    </div>

                    <div class="uk-width-medium-2-10">
                        <div class="uk-margin-small-top">
                            <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?=Uni::t('app',"Drup category")?></option>
                                <?php foreach ($items as $item): ?>
                                    <option value="<?=$item->id?>"><?= ($item->name)?$item->name:Uni::t('app',"Not set") ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-10">
                        <div class="uk-margin-top uk-text-nowrap">
                            <input type="checkbox" name="product_search_active" id="product_search_active" data-md-icheck/>
                            <label for="product_search_active" class="inline-label"><?=Uni::t('app',"Active")?></label>
                        </div>
                    </div>
                    <div class="uk-width-medium-2-10 uk-text-center">
                        <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="md-card">
        <div class="md-card-content">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10"><?= Uni::t('app', 'Vaccine name') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Drug type') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Unit') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Dose') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Created') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($query)) $vaksina->models = $query->models; ?>
                <?php if (!empty($vaksina->models)): ?>
                    <? foreach ($vaksina->models as $model) { ?>
                        <tr id='row_<?=$model->id?>'>
                            <? $st = $model->status; ?>
                            <td class="uk-text-center uk-table-middle small_col">
                                <input type="checkbox" data-md-icheck class="check_row"/>
                            </td>
                            <td class="uk-width-2-10"><?= ($model->name)?$model->name:Yii::t('app',"Not set") ?></td>
                            <td class="uk-width-2-10 uk-text-center"><?= ($model->turi)?$model->turi->name:Uni::t('app',"Not set")?></td>
                            <td class="uk-width-2-10 uk-text-center"><?= $model->unit->name?></td>
                            <td class="uk-width-2-10 uk-text-center"><?= $model->doza?></td>
                            <td class="uk-width-2-10 uk-text-center"><?=date('d-m-Y', $model->created_date)?></td>
                            <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>">
                                    <i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i>
                                </a>
                            </td>
                            <td class="uk-text-center">
                                <a class="modal-edit-direction" data-id="<?=$model->id?>" data-title="<?=$model->name_ru?>" data-short="<?=$model->name_uz?>" data-speciality="<?=$model->vk_turi?>">
                                    <i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                                <a href="<?=Url::to("settings/vaksina/views/$model->id")?>" data-id="<?= $item->id ?>"><i
                                            class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                                <a class="modal-delete-direction" type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_delete'}"><i
                                        class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a>
                            </td>
                        </tr>
                    <? } ?>
                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

<?= uni\widgets\LinkPager::widget([
    'pagination' => $vaksina->pagination,
    'options'=>['class' => 'uk-pagination']
]) ?>

    <!--- Modal New Direction Add -->
    <div class="uk-modal" id="modal_add_direction">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formDirection']); ?>
            <div class="uk-form-row">
                <?= $form->field($new, 'vk_turi')->dropDownList($map,['prompt'=>Uni::t("app", "Choose the vaccine type"),'tabindex' => 1])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_ru')->textInput() ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_uz')->textInput() ?>
            </div>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-2-4">
                    <?= $form->field($new, 'unit_id')->dropDownList($unit) ?>
                </div>
                <div class="uk-width-medium-2-4">
                    <?= $form->field($new, 'doza')->textInput() ?>
                </div>
            </div>
            <div class="uk-grid">
                <div data-dynamic-fields="field_template_modal"></div>
                <script id="field_template_modal" type="text/x-handlebars-template">
                    <div class="uk-grid form_section">
                        <div class="uk-width-1-1">
                            <div class="uk-input-group">
                                <label for="d_form_address{{counter}}"><?=Uni::t('app', 'Fields')?></label>
                                <input type="text" class="md-input" name="d_form_address{{counter}}" id="d_form_address{{counter}}">
                                <span class="uk-input-group-addon">
                                                    <a href="#" class="btnSectionClone"><i class="material-icons md-24">&#xE146;</i></a>
                                                </span>
                            </div>
                        </div>
                    </div>
                </script>
            </div>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-4">
                    <?= $form->field($new, 'mol')->textInput() ?>

                </div>
                <div class="uk-width-medium-1-4">
                    <?= $form->field($new, 'qoy')->textInput() ?>

                </div>
                <div class="uk-width-medium-1-4">
                    <?= $form->field($new, 'tovuq')->textInput() ?>

                </div>
                <div class="uk-width-medium-1-4">
                    <?= $form->field($new, 'mushuk')->textInput() ?>

                </div>

            </div>
            <input type="hidden" id="directionAdd"/>
            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveDirection']) ?>
            <?php Form::end(); ?>
        </div>
    </div>

    <!--  Modal Notification after adding New Direction -->
    <div class="uk-modal" id="modal_notificationDirection">
        <div class="uk-modal-dialog" style="min-height: 400px">
            <button type="button" class="uk-modal-close uk-close"></button>
            <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/direction')?>'><?=Uni::t('app','Video list')?></a>
            <button class="md-btn md-btn-primary" id='addAnotherDirection'><?=Uni::t('app','Add')?></button>
        </div>
    </div>

    <!---   Modal Direction View -->
    <div class="uk-modal" id="modal_view" aria-hidden="true" style="display: none; overflow-y: scroll;">
        <div class="uk-modal-dialog" style="top: 34.5px;">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title"><?= Uni::t('app', 'Vaccine') ?></h3>
            </div>
            <table class="uk-table uk-table-hover uk-table-bordered">
                <thead>
                <tr>
                    <th><?=Uni::t('app', 'Vaccine type')?></th>
                    <th  colspan="2" style="text-align: center"><?=Uni::t('app', 'Vaccine name')?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td id="modal_view_viloyat"></td>
                    <td id="modal_view_text"></td>
                    <td id="modal_view_text2"></td>
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
                <?= $form->field($new, 'name_ru')->textInput(['id' => 'dir-title']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_uz')->textInput(['id' => 'dir-short']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'vk_turi')->dropDownList($map, ['id' => 'dir-speciality']) ?>
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
                $("#modal_view_viloyat").html(response.viloyat_id);
            }
            else {
                $("#modal_view_text").html(response);
                $("#modal_view_text2").html(response);
            }
        });
    });

     $(\'.modal-delete-direction\').click(function(){
        var pk=$(this).attr("data-id");
        var url=\'../vaksina/delete/\'+pk;
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


?>