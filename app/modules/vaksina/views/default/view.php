<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 17.12.2018 12:42
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
\app\components\widgets\SweetAlertAsset::register($this);

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Vaccine');

?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('vaksinatsiya/default/index')?>"><?=Uni::t('app','Back')?></a>
            <!-- <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button> -->
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
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Prixod name')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><a href="#"><?=$prixod->name?></a></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Vaksina name')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$prixod->vaksina->name?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Unit')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$prixod->unit->name_uz?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider uk-hidden-large">
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Distributor')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><a href="#"><?=$prixod->user->makeFIO()?></a></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Created date')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=date('d-m-Y', $prixod->created_date)?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Number')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$prixod->name_uz?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-width-xLarge-3-10 uk-width-large-4-10">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    <?=Uni::t('app','Data')?>
                </h3>
            </div>
            <div class="md-card-content">
                <ul class="md-list">
                    <li>
                        <div class="md-list-content">
                            <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','All')?></span>
                            <span class="md-list-heading uk-text-large uk-text-success"><?=$prixod->count?></span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','Tarqatilgan')?></span>
                            <span class="md-list-heading uk-text-large uk-text-success"><?=$prixod->count-$prixod->ostatok?></span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','Qoldiq')?></span>
                            <span class="md-list-heading uk-text-large uk-text-success"><?=$prixod->ostatok?></span>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>


<div class="md-card">
    <div class="md-card-content">
        <table class="uk-table uk-table-nowrap uk-table-hover table_check">
            <thead>

            <tr>
                <th class="uk-width-1-10 uk-text-center small_col">
                    <input type="checkbox" data-md-icheck class="check_all"></th>

                <th class="uk-width-2-10"><?= Uni::t('app', 'Region') ?></th>
                <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Vaccine count') ?></th>
                <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Vaccine balance') ?></th>
                <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'FIO') ?></th>
                <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Created') ?></th>
                <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($query)) $viloyat->models = $query->models; ?>
            <?php if (!empty($viloyat->models)): ?>
                <? foreach ($viloyat->models as $model) { ?>
                    <tr id='row_<?=$model->id?>' >

                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-width-2-10 "><?= ($model->viloyat_id)?$model->viloyat->name:Yii::t('app',"Not set") ?></td>
                        <td class="uk-width-1-10 uk-text-left"><?=$model->vaksina_miqdor?></td>
                        <td class="uk-width-1-10 uk-text-left"><?=$model->ostatok?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->user->makeFIO()?></td>
                        <td class="uk-width-1-10 uk-text-center"><?=date('d-m-Y', $model->proxod_date)?></td>
                        <td class="uk-width-1-10 uk-text-center">
                            <?if($model->status==0){?>
                                <span class="uk-badge uk-badge-info"><?=Uni::t('app','Not seen')?></span>
                            <?}elseif($model->status==1){?>
                                <span class="uk-badge uk-badge-success"><?=Uni::t('app','Accepted')?></span>
                            <?}elseif($model->status==2){?>
                                <span class="uk-badge uk-badge-danger"><?=Uni::t('app','Denied')?></span>
                            <?}?>
                        </td>
                        <td class="uk-text-center">
                            <a type="button" href="<?#=Url::to('settings/arrival/prixod/'.$model->id)?>"><i
                                    class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                        </td>
                    </tr>

                <? } ?>

            <?php endif; ?>
            </tbody>
        </table>


    </div>
</div>

<?= uni\widgets\LinkPager::widget([
    'pagination' => $viloyat->pagination,
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
        <table class="uk-table uk-table-hover uk-table-hover uk-table-bordered">
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
