<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 22.11.2018 12:08
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;

//\app\components\widgets\SweetAlertAsset::register($this);
$current = Lang::getCurrent();
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$this->title = Uni::t('app', 'Regions');
?>
    <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('settings/viloyat/index')?>"><?=Uni::t('app','All')?></a>
                <button type="button" class="md-btn"
                        onclick="UIkit.modal.prompt('Viloyat nomi:', 'Название области',''/*, function(val){ UIkit.modal.alert('Hello '+(val || 'Mr noname')+'!'); }*/);"><?= Uni::t('app', 'Add region') ?></button>
            </div>
            <div class="uk-width-1-2">
                <form method="get">
                    <div class="uk-grid">
                        <div class="uk-width-3-4">
                            <input class="md-input" placeholder="<?=Uni::t('app', 'search')?>..." <?=$q?" value='".$q."'":""?> name="q" type="text">
                        </div>
                        <div class="uk-width-1-4">
                            <button type="submit" class="md-btn md-btn-success"><i class="material-icons"><?=Uni::t('app', 'search')?></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <div class="md-card">
    <div class="md-card-content">

        <table class="uk-table uk-table-nowrap table_check">
            <thead>
            <tr>
                <th class="uk-width-1-10 uk-text-center small_col">
                    <input type="checkbox" data-md-icheck class="check_all"></th>

                <th class="uk-width-2-10"><?= Uni::t('app', 'Region name') ?></th>
                <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Created') ?></th>
                <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                <? //= Uni::t('app', 'Phone') ?><!--</th>-->
                <!--                <th class="uk-width-1-10 uk-text-center">-->
                <? //= Uni::t('app', 'Status') ?><!--</th>-->
                <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($query)) $items->models = $query->models; ?>
            <?php if (!empty($items->models)): ?>
                <? foreach ($items->models as $model) { ?>
                    <tr id="id_<?= $model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td><?= ($current->url == "ru") ? $model->name_ru : $model->name_uz ?></td>
                        <td class="uk-text-center"><?= date('d-m-Y', $model->created_at) ?></td>
                        <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-statusspe" >
                                <i class="md-icon material-icons uk-text-primary checkbox" data-value="<?=$model->id?>"  data-id="<?=$model->status?>"><?=($model->status==0)?"&#xE835;":"&#xE834;"?></i></a>
                        </td>
                        <td class="uk-text-center">
                            <a type="button" data-id="<?= $model->id ?>"
                               data-uk-modal="{target:'#modal_header_footer'}"><i
                                        class="md-icon material-icons uk-text-primary ruchka">&#xE254;</i></a>
                            <a type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_view'}"><i
                                        class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                            <a type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_delete'}"><i
                                        class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a>
                        </td>
                    </tr>
                <? } ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?= uni\widgets\LinkPager::widget([
        'pagination' => $items->pagination,
        'options'=>['class' => 'uk-pagination']
    ]) ?>

    <div class="uk-modal uk-modal-dialog-replace" id="modal_header_footer" aria-hidden="true"
         style="display: none; overflow-y: scroll;">
        <div class="uk-modal-dialog" style="min-height: 0px; top: 46.5px;">
            <div>
                <div class="uk-modal-content uk-margin-top">
                    <div class="md-input-wrapper">
                        <table class="uk-table uk-table-hover">
                            <thead>
                            <tr>
                                <th><?= Uni::t('app', 'Name ru') ?></th>
                                <th><?= Uni::t('app', 'Name uz') ?></th>
                            </tr>
                            </thead>
                            <tr>
                                <td>
                                    <input type="text" value="" id="md-input1" data-id="" class="md-input"><span
                                            class="md-input-bar "></span></td>
                                <td>
                                    <input type="text" value="" id="md-input2" class="md-input"><span
                                            class="md-input-bar "></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button"
                            class="uk-modal-close md-btn md-btn-flat"><?= Uni::t('app', 'Cancel') ?></button>
                    <button type="button"
                            class="js-modal-ok md-btn-flat-primary md-btn md-btn-flat"><?= Uni::t('app', 'Save') ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-modal" id="modal_view" aria-hidden="true" style="display: none; overflow-y: scroll;">
        <div class="uk-modal-dialog" style="top: 34.5px;">
            <div class="uk-modal-header">
                <h3 class="uk-modal-title"><?= Uni::t('app', 'Region name') ?></h3>
            </div>
            <table class="uk-table uk-table-hover">
                <tr>
                    <td id="modal_view_text"></td>
                    <td id="modal_view_text2"></td>
                </tr>
            </table>
            <p id="modal_view_text2">.</p>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close"><?= Uni::t('app', 'Close') ?></button>
            </div>
        </div>
    </div>
    <div class="uk-modal uk-modal-dialog-replace" id="modal_delete" aria-hidden="false"
         style="display: none; overflow-y: scroll;">
        <div class="uk-modal-dialog" style="min-height: 0px; top: 79px;">
            <div>
                <div class="uk-margin uk-modal-content"><?=Uni::t('app', 'Are you sure?')?></div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-modal-close md-btn md-btn-flat"><?=Uni::t('app', 'Cancel')?></button>
                    <button data-id="" class="js-modal-confirm md-btn-flat-primary md-btn md-btn-flat"><?=Uni::t('app', 'Ok')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="text"></div>

<?php

$this->registerJs(' /* O`chirish tugmasi*/
    $("button.js-modal-confirm").click(function(e){
        e.preventDefault();
        var model= $(this).attr("data-id");
        //console.log(id);
        $.get("../viloyat/delete",{id:model},function(response){
            if(response=="success"){
                $("#modal_delete").hide();
                $("#id_"+model).remove();
            }
            else UIkit.modal.alert(response);
        });
    });
');

$this->registerJs(' /* O`chirishni bosganda, Okga uzatish*/
    $("i.uk-text-danger").click(function(e){
        e.preventDefault();
        var model= $(this).parent().attr("data-id");
        $("button.md-btn-flat-primary").attr("data-id", model);
    });
');

$this->registerJs(' /* statusni o`zgartirish*/
    $("i.checkbox").click(function(e){
        //e.preventDefault();
        var model= $(this).attr("data-id");
        var value= $(this).attr("data-value");
        console.log($(this).html()); 
        switch (model) {
          case "0":
            $.get("../viloyat/change",{id: value, status:1},function(response){
                if(response=="success"){
                    window.location.reload();
                }
                else UIkit.modal.alert(response);
            });
            break;
          case "1":
            $.get("../viloyat/change",{id: value, status:0},function(response){
                if(response=="success"){
                    window.location.reload();
                }
                else UIkit.modal.alert(response);
            });
            break;
          default:
            alert( \'Я таких значений не знаю\' );
        }
        
    });    
');

$this->registerJs(' /*tahrirlashda ok tugmasi bosilsa*/
    $("button.md-btn-flat-primary").click(function(e){
        e.preventDefault();
        var input1= $("#md-input1").val();
        var id= $("#md-input1").attr("data-id");
        var input2= $("#md-input2").val();
        //console.log(id);
        $.get("../viloyat/edit",{text1: input1, text2: input2, id:id},function(response){
            if(response=="success"){
                window.location.reload();
            }
            else UIkit.modal.alert(response);
        });
    });
');

$this->registerJs(' /* tahrirlash*/
    $("i.ruchka").click(function(e){
        e.preventDefault();
        var model= $(this).parent().attr("data-id");
        $("#md-input1").attr("data-id", model);
        $.get("../viloyat/update",{id: model},function(response){
            if(response!="error"){
                $("#md-input1").val(response.name_ru);
                $("#md-input2").val(response.name_uz);
            }
            else UIkit.modal.alert(response);
        });
    });
');

$this->registerJs(' /*ko`rish oynasi*/
    $("i.eye").click(function(e){
        e.preventDefault();
        var model= $(this).parent().attr("data-id");
        $.get("../viloyat/view",{id: model},function(response){
            if(response!="error"){
                $("#modal_view_text").html(response.name_ru);
                $("#modal_view_text2").html(response.name_uz);
            }
            else {
                $("#modal_view_text").html(response);
                $("#modal_view_text2").html(response);
            }
        });
    });
    
');

$this->registerJs('
  UIkit.modal.prompt = function(text, text2,value, onsubmit, options) {
    
         onsubmit = UIkit.$.isFunction(onsubmit) ? onsubmit : function(value){};
         options  = UIkit.$.extend(true, {bgclose:false, keyboard:false, modal:false, labels:UIkit.modal.labels}, options);
    
         var modal = UIkit.modal.dialog(([
                 text ? \'<div class="uk-modal-content uk-form">\'+String(text)+\'</div>\':\'\',
                 \'<div class="uk-margin-small-top uk-modal-content uk-form"><p><input type="text" id="bir" class="uk-width-1-1"></p></div>\',
                 text2 ? \'<div class="uk-modal-content uk-form">\'+String(text2)+\'</div>\':\'\',
                 \'<div class="uk-margin-small-top uk-modal-content uk-form"><p><input type="text" id="ikki" class="uk-width-1-1"></p></div>\',
                 \'<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-modal-close">\'+options.labels.Cancel+\'</button> <button class="uk-button uk-button-primary js-modal-ok">\'+options.labels.Ok+\'</button></div>\'
             ]).join(""), options),
    
             input = modal.element.find("#bir").val(value || \'\').on(\'keyup\', function(e){
                 if (e.keyCode == 13) {
                     modal.element.find(".js-modal-ok").trigger(\'click\');
                 }
             });   
             input2 = modal.element.find("#ikki").val(value || \'\').on(\'keyup\', function(e){
                 if (e.keyCode == 13) {
                     modal.element.find(".js-modal-ok").trigger(\'click\');
                 }
             });
    
         modal.element.find(".js-modal-ok").on("click", function(){
             if (onsubmit(input.val())!==false){
                 $.get("../viloyat/create",{input: input.val(), input2:input2.val()},function(response){
                    if(response=="success"){
                        window.location.reload();
                    }
                    else UIkit.modal.alert(response);
                });
                 //modal.hide();
             }
         });
    
         return modal.show();
     };
');
/***
 * var text = \'<div class="uk-modal" id="modal_view_\'+model+\'" aria-hidden="true" style="display: none; overflow-y: scroll;">\'+
 * \'<div class="uk-modal-dialog" style="top: 34.5px;">\'+
 * \'<div class="uk-modal-header">\'+
 * \'<h3 class="uk-modal-title">Headline</h3>\'+
 * \'</div>\'+
 * \'<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, aliquid amet animi aspernatur aut blanditiis doloribus eligendi est fugiat iure iusto laborum modi mollitia nemo pariatur, rem tempore. Dolor, excepturi.</p>\'+
 * \'<div class="uk-modal-footer uk-text-right">\'+
 * \'<button type="button" class="md-btn md-btn-flat uk-modal-close">'.Uni::t("app", "Close").'</button>\'+
 * \'</div>\'+
 * \'</div>\'+
 * \'</div>\';
 */
