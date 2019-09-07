<?php

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
$q=false;
// if(isset($_GET['q'])){
// $q=$_GET['q'];
// }
// $current = Lang::getCurrent();

$this->title = Uni::t('app','Preparat')." | ".Uni::t('app', 'Preparat view');
?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
             <a class="md-btn md-btn-facebook md-btn-small" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
            <?php if(Uni::$app->controller->access('ADMIN') || Uni::$app->controller->access('HEAD')){ ?>
            <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('preparat/')?>"><?=Uni::t('app','List')?></a>
            <a class="md-btn md-btn-warning md-btn-small" href="<?=Url::to('preparat/default/edit/'.$model->id)?>"><?=Uni::t('app','Edit')?></a>
            <a id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-primary md-btn-small" href="<?=Url::to('preparat/add')?>"><?=Uni::t('app','Add new')?></a>
            <?php } ?>
            <!-- <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button> -->
        </div>

    </div>
</div>
<br>
<div class="uk-grid uk-grid-medium">
    <div class="uk-width-xLarge-7-10  uk-width-large-6-10 uk-row-first">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    <?=Uni::t('app','Details')?>
                </h3>
            </div>
            <div class="md-card-content large-padding">
                <div class="uk-grid uk-grid-divider uk-grid-medium">
                    <div class="uk-width-large-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Vaccine name')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$model->name?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Vaccine type')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$model->turi->name?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Unit')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$model->unit->name?>
                            </div>
                        </div>


                        <hr class="uk-grid-divider uk-hidden-large">
                    </div>

                    <div class="uk-width-large-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','File')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?php if($model->file!=null){?>
                                    <a href="<?=Url::to('preparat/default/download/'.$model->id)?>" target="_blank">
                                        <i class="md-list-addon-icon material-icons"></i></a>
                                <?}else{?>
                                    <?=Uni::t('app','File do not uploaded')?>
                                <?} ?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <?php  foreach ($model->animal as $item): ?>
                        <?php if ($item->category_id==0) break; ?>
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app', 'Animal types')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=($item->hayvon)? $item->hayvon->name: ""?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <?php endforeach; ?>
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Doza')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$model->doza?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="uk-grid">
    <div class="uk-width-2-2">
        <div class="md-card-content">

            <h2><?=$this->title?></h2>
        </div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">

                    <table class="uk-table uk-table-nowrap table_check uk-table-hover">
                        <thead>

                        <tr>
                            <th class="uk-width-1-10 uk-text-center small_col">
                                <?=Uni::t('app', 'emlama')?>
                            </th>
                            <th class="uk-width-1-10"><?=Uni::t('app','Temperature')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','emlash')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Vaccine time')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Vaccine territory') ?></th>
                            <th class="uk-width-2-10 uk-text-left"><?=Uni::t('app','Animal type and age')?></th>
                            <th class="uk-width-2-10 uk-text-left"><?=Uni::t('app','For vaccine')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Vaccine era')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Revaccine')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Laboratoriya diagnos')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Vaccine requirements and restrictions')?></th>
                            <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Immunitet')?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($model->animal as $model) {?>
                            <tr id="row_<?=$model->id ?>">
                                <td class="uk-text-center uk-table-middle small_col">
                                    <?=$model->vaksina->name?>                           </td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->temperatura?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->emlash?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->emlash_vaqti?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->emlash_hududi?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->hayvon_turi_yoshi?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->emlash_uchun?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->emlash_davri?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->revaksinatsiya?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->laboratoriya_diagnos?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->talab_cheklash?></td>
                                <td class="uk-width-1-10 uk-text-left"><?=$model->immunitet?></td>

                            </tr>
                        <?}?>
                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>
</div>
<!--- Modal New Direction Add -->
<div class="uk-modal" id="modal_add_direction">
    <div class="uk-modal-dialog uk-modal-dialog-large">
        <button type="button" class="uk-modal-close uk-close"></button>
        <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formDirection','options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-3">
                <?= $form->field($new, 'vk_turi')->dropDownList($map,['prompt'=>Uni::t("app", "Choose the vaccine type"),'tabindex' => 1])->label(false) ?>
            </div>
            <div class="uk-width-medium-1-3">
                <?= $form->field($new, 'name_ru')->textInput(['required' => 'required']) ?>
            </div>
            <div class="uk-width-medium-1-3">
                <?= $form->field($new, 'name_uz')->textInput() ?>
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-3">
                <select class="md-input" id="category_id" name="category_id">
                    <?php foreach ($hayvon as $item): ?>
                        <option  value="<?=$item->id?>"><?= ($item->name)?$item->name:Uni::t('app',"Not set") ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="uk-width-medium-1-3">
                <select id="emlash_turi" class="md-input" required name="emlash_turi">
                    <option value="0"><?=Uni::t('app', 'Profilaktik')?></option>
                    <option value="1"><?=Uni::t('app', 'Required')?></option>
                </select>
            </div>
            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" required  name="temperatura" id="temperatura" placeholder="<?=Uni::t('app', 'Temperature')?>">
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin="">

            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="emlash_uchun" id="emlash_uchun" placeholder="<?=Uni::t('app', 'For vaccine')?>">
            </div>
            <div class="uk-width-medium-1-3">
                <?= $form->field($new, 'unit_id')->dropDownList($unit) ?>
            </div>
            <div class="uk-width-medium-1-3">
                <?= $form->field($new, 'doza')->textInput() ?>
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-2-3">
                <input type="text" class="md-input" name="emlash_hududi" id="emlash_hududi" placeholder="<?=Uni::t('app', 'Vaccine territory')?>">
            </div>

            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="hayvon_turi_yoshi" id="hayvon_turi_yoshi" placeholder="<?=Uni::t('app', 'Animal type and age')?>">
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="emlash_davri" id="emlash_davri" placeholder="<?=Uni::t('app', 'Vaccine era')?>">
            </div>
            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="revaksinatsiya" id="revaksinatsiya" placeholder="<?=Uni::t('app', 'Revaccine')?>">
            </div>
            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="immunitet" id="immunitet" placeholder="<?=Uni::t('app', 'Immunitet')?>">
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="emlash_vaqti" id="emlash_vaqti" placeholder="<?=Uni::t('app', 'Vaccine time')?>">
            </div>
            <div class="uk-width-medium-2-3">
                <input type="text" class="md-input" name="laboratoriya_diagnos" id="laboratoriya_diagnos" placeholder="<?=Uni::t('app', 'Laboratoriya diagnos')?>">
            </div>

        </div>
        <div class="uk-grid" data-uk-grid-margin="">

            <div class="md-input-wrapper md-input-filled">
                <textarea class="md-input autosized" cols="30" rows="4" name="talab_cheklash" id="talab_cheklash" placeholder="<?=Uni::t('app', 'Vaccine requirements and restrictions')?>"></textarea>
            </div>

        </div>


        <input type="hidden" id="directionAdd"/>
        <br/>
        <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveDirection']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Notification after adding New VkVaksina -->
<div class="uk-modal" id="modal_notificationVkViloyat">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('preparat')?>'><?=Uni::t('app','Vaksina list')?></a>
<!--        <button class="md-btn md-btn-primary" id='addAnotherVkViloyat' >--><?//=Uni::t('app','Add')?><!--</button>-->
    </div>
</div>
