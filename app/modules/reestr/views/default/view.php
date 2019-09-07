<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 14.12.2018 20:59
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use uni\helpers\Html;
use uni\ui\Form;
use app\components\manager\Url;

\app\components\widgets\SweetAlertAsset::register($this);
//$this->registerJsFile('/themes/ui/assets/js/reestr.js',['depends'=>['app\assets\CoreAssets']]);
//$this->registerJs('Reestr.openCreateForm();Muxr.openClearedDirection();Reestr.saveReestrCon();Reestr.openEditReestrForm();Reestr.editReestrStatus();');


$this->title = Uni::t('app', 'Reestr')." | ".$model->name_businesses;
?>
<div id="page_content_inner">
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="javascript:history.back()"><?=Uni::t('app','Back')?></a>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a"><?=$this->title?></h3>
                    <div class="uk-grid uk-grid-divider" data-uk-grid-margin="" style="margin-top:40px">
                        <div class="uk-width-large-2-4 uk-width-medium-1-2">
                            <ul class="md-list">
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Activity type')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->type->name?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Company name')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$this->title?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'FIO')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->fio?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Region')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->viloyat->name?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'City')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->tuman->name?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Address')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->adress?></span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="uk-width-large-2-4 uk-width-medium-1-2">
                            <ul class="md-list">
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Bank')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->bank?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'р/н')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->rs?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'INN')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->stir?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'МФО')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->mfo?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Код ОКЕД')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->oked?></span>
                                    </div>
                                </li>
                                <li>
                                    <div class="md-list-content">
                                        <span class="md-list-heading"><?=Uni::t('app', 'Special Code')?></span>
                                        <span class="uk-text-small uk-text-muted"><?=$model->special_code?></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="md-card">
                <div class="md-card-content" >
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-hover">
                            <caption><?=Uni::t('app','History of company')?></caption>
                            <thead>
                            <tr>
                                <th><?=Uni::t('app', 'Comment')?></th>
                                <th><?=Uni::t('app', 'Date')?></th>
                                <th><?=Uni::t('app','File')?></th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php if(!empty($contra)):  ?>
                            <?php foreach ($contra as $item): ?>
                            <tr>
                                <td><?=$item->comment?></td>
                                <td><?=date('d-m-Y', $item->date)?></td>
                                <td>
                                    <?php if($item->file!=null){?>
                                        <a href="<?=Url::to('reestr/default/download/'.$item->id)?>" target="_blank">
                                            <i class="md-list-addon-icon material-icons"></i></a>
                                    <?}else{?>
                                        <!-- <i class="md-list-addon-icon material-icons"></i></a> -->
                                    <?} ?>
                                    </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <div class="md-card">
                <div class="md-card-content" >
                    <h3 class="heading_a"><?=Uni::t('app','Add contravention')?></h3>
                    <?php $form = Form::begin(['id'=>'formCon', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="uk-form-row">
                        <?= $form->field($con, 'company_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($con, 'date')->textInput(['data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($con, 'comment')->textarea() ?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($con, 'file')->fileInput() ?>
                    </div>
                    <?= Html::button(Uni::t('app', 'Save'), ['type'=>'submit','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveContr','style'=>'margin-top:90px']) ?>
                    <?php Form::end(); ?>
                </div>
            </div>
        </div>
        <div class="uk-width-1-2">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a"><?=Uni::t('app','Add ban')?></h3>
                    <?php $form = Form::begin(['id'=>'formDirectionEdit','options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="uk-form-row">
                        <?= $form->field($ban, 'company_id')->hiddenInput(['value' => $model->id])->label(false) ?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($ban, 'start_date')->textInput(['data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($ban, 'end_date')->textInput(['data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($ban, 'comment')->textarea() ?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($ban, 'file')->fileInput() ?>
                    </div>
                    <br/>
                    <?= Html::button(Uni::t('app', 'Save'), ['type'=>'submit','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'SaveBan',]) ?>
                    <?php Form::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php if(!empty($xabar)) {
    $this->registerJs('
        UIkit.modal.alert("'.Uni::t("app", "$xabar").'");
    ');
}
?>