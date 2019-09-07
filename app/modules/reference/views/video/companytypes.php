<?
use uni\ui\Html;
use uni\ui\Form;
use app\components\manager\Url;
\app\components\widgets\SweetAlertAsset::register($this);
$m=new \app\models\CompanyTypes();
$this->registerJs("Muxr.saveCompanyType();Muxr.deleteCompanyType();Muxr.updateCompanyType();");
?>
<div class="block-process" style="margin-bottom:10px;">
    <a class="md-btn md-btn-success" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
</div>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10">Name</th>
                    <th class="uk-width-2-10">Description</th>
                    <th class="uk-width-1-10 uk-text-center">Status</th>
                    <th class="uk-width-2-10 uk-text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr>
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td><?=$model->name?></td>
                        <td><?=$model->description?></td>
                        <td class="uk-text-center">
                            <?if($model->status){?> <span class="uk-badge">Active</span><?}else{?>
                                <span class="uk-badge uk-badge-danger">inActive</span>
                            <?}?>
                        </td>
                        <td class="uk-text-center">
                            <div class="md-btn-group md-btn-group-sm" role="group">
                                <a href="#" class="editType" title="<?= Uni::t('app', 'Edit company type') ?>" data-pk="<?=$model->primaryKey?>" data-status="<?=$model->status?>" data-name="<?=$model->name?>" data-desc="<?=$model->description?>">
                                    <i class="md-icon material-icons uk-text-success">&#xE3C9;</i>
                                </a>
                                <span data-pk="<?=$model->primaryKey?>" class="deleteType uk-text-danger" title="<?= Uni::t('app', 'Delete item') ?>">
                                    <i class="md-icon material-icons uk-text-danger">&#xE15C;</i>
                                </span>
                            </div>
                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>
        <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination
        ]) ?>

    </div>
</div>

<div class="md-fab-wrapper">
    <a class="md-fab md-fab-primary" data-uk-modal="{target:'#modal_add'}" data-uk-tooltip="{pos:'right'}" title="Create new doc type"><i class="material-icons">&#xE145;</i></a>

</div>

<div class="uk-modal" id="modal_add">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <div class="uk-form-row">
            <?php $form = Form::begin(['enableAjaxValidation' => true]); ?>
            <?=$form->field($m,'name')->textInput(['id'=>'typeName'])?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($m, 'description')->textInput(['id'=>'typeDesc']) ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($m, 'status')->checkbox(['id'=>'typeStatus']) ?>
        </div>
        <br/>
        <input type="hidden" id="typePk"/>
        <?= Html::button(Uni::t('app', 'Save'), ['class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveCompanyType']) ?>
        <?php Form::end(); ?>
    </div>
</div>