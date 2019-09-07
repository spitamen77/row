<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 10.12.2018 10:58
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveColor();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openEditColorForm();Muxr.editColorStatus();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Animal color');
?>
    <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('settings/color/index')?>"><?=Uni::t('app','All')?></a>
                <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add color')?></button>
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
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10"><?= Uni::t('app', 'Color name') ?></th>
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
                        <tr id='row_<?=$model->id?>'>
                            <? $st = $model->status; ?>
                            <td class="uk-text-center uk-table-middle small_col">
                                <input type="checkbox" data-md-icheck class="check_row"/>
                            </td>
                            <td class="uk-width-2-10"><?= ($model->name)?$model->name:Yii::t('app',"Not set") ?></td>
                            <td class="uk-width-2-10 uk-text-center"><?=date('d-m-Y', $model->created_date)?></td>
                            <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>">
                                    <i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i>
                                </a>
                            </td>
                            <td class="uk-text-center">
                                <a class="modal-edit-direction" data-id="<?=$model->id?>" data-title="<?=$model->name_ru?>" data-short="<?=$model->name_uz?>">
                                    <i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                                <a type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_view'}"><i
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
                <h3 class="uk-modal-title"><?= Uni::t('app', 'Animal color') ?></h3>
            </div>
            <table class="uk-table uk-table-hover uk-table-bordered">
                <!--                <thead>-->
                <!--                <tr>-->
                <!--                    <th>--><?//=Uni::t('app', 'Region')?><!--</th>-->
                <!--                    <th style="text-align: center">--><?//=Uni::t('app', 'City')?><!--</th>-->
                <!--                </tr>-->
                <!--                </thead>-->
                <tbody>
                <tr>
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
        $.get("../color/view",{id: model},function(response){
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

     $(\'.modal-delete-direction\').click(function(){
        var pk=$(this).attr("data-id");
        var url=\'../color/delete/\'+pk;
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