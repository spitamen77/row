<?php
use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
use uni\widgets\Pjax;

\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJsFile('/themes/ui/assets/js/reestr.js',['depends'=>['app\assets\CoreAssets']]);
$this->registerJs('Reestr.openCreateForm();Muxr.openClearedDirection();Reestr.saveReestr();Reestr.openEditReestrForm();Reestr.editReestrStatus();');

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Reestr');
if ($current->url=="ru") $map = ArrayHelper::map($viloyat,'id','name_ru');
else $map = ArrayHelper::map($viloyat,'id','name_uz');
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
     console.log('end');
        $.pjax.reload({container:'#listData'});
        bindFilterForm();
    });
");
?>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-2-10">
                    <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reestr/default/index')?>"><?=Uni::t('app','All')?></a>
                    <button id="modal_add_reestr_btn" data-uk-modal="{bgClose:true;modal:true;}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add')?></button>
                </div>
                <div class="uk-width-medium-8-10">
                    <?Pjax::begin(['id'=>'filterData'])?>
                    <?Form::begin(['id'=>'filterForm','method'=>'get','action'=>Url::getMain(),'options' => ['class' => '', 'data-pjax' => true]])?>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-2-10">
                                <div class="uk-margin-small-top">
                                    <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                                        <option value=""><?=Uni::t('app',"Region category")?></option>
                                        <? foreach (\app\models\Viloyat::find()->orderBy(['id'=>SORT_DESC])->all() as $v) { ?>

                                            <option value="<?=$v->id?>"><?=$v->name?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="uk-width-medium-3-10">
                                <label for="product_search_name"><?=Uni::t('app',"Company name")?></label>
                                <input name="name" type="text" class="md-input" id="product_search_name">
                            </div>
                            <div class="uk-width-medium-2-10">
                                <label for="product_search_name"><?=Uni::t('app',"Address")?></label>
                                <input name="address" type="text" class="md-input" id="product_search_name">
                            </div>
                            <div class="uk-width-medium-2-10 uk-text-center">
                                <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                            </div>
                        </div>
                    <?Form::end() ?>
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

                    <th class="uk-width-1-10"><?= Uni::t('app', 'Region') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Type activity') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Company name') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Tuman') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Adress') ?></th>
                    <!--                    <th class="uk-width-1-10 uk-text-center">--><?//= Uni::t('app', 'INN') ?><!--</th>-->
<!--                    <th class="uk-width-1-10 uk-text-center">--><?//= Uni::t('app', 'Special code') ?><!--</th>-->
                    <!-- <th class="uk-width-1-10 uk-text-center"><?//= Uni::t('app', 'Created time') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?//= Uni::t('app', 'Update time') ?></th> -->
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                </tr>
                </thead>

                <tbody>

                <?php if (!empty($items->models)): ?>
                    <?php $i=0; foreach ($items->models as $model) {$i++;
                        if (!Uni::$app->controller->access('ADMIN'))
                            if ($model->viloyat_id != Uni::$app->getUser()->identity->viloyat_id) continue;
                        ?>
                        <tr id='row_<?=$model->id?>'>
                            <? $st = $model->status; ?>
                            <td class="uk-text-center uk-table-middle small_col">
                                <?=$i?>
                            </td>

                            <td class="uk-width-2-10"><?=($model->viloyat)?$model->viloyat->name:""?></td>
                            <td class="uk-width-2-10 uk-text-center"><?=($model->type)?$model->type->name:""?></td>
                            <td class="uk-width-2-10 uk-text-center"><?=$model->name_businesses?></td>
                            <td class="uk-width-1-10 uk-text-center"><?=($model->tuman)?$model->tuman->name:""?></td>
                            <td class="uk-width-2-10 uk-text-center"><?=$model->adress?></td>
                            <!--                            <td class="uk-width-2-10 uk-text-center">--><?//=$model->stir?><!--</td>-->
<!--                            <td class="uk-width-2-10 uk-text-center">--><?//=$model->special_code?><!--</td>-->
                            <!-- <td class="uk-width-2-10 uk-text-center"><?//=date('d-m-Y', $model->created_date)?></td>
                            <td class="uk-width-2-10 uk-text-center"><?//=date('d-m-Y', $model->updated_date)?></td> -->

                            <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>">
                                    <i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i>
                                </a>
                            </td>

                            <td class="uk-text-center">
                                <a class="modal-edit-direction" data-id="<?=$model->id?>" data-name-businesses="<?=$model->name_businesses?>" data-stir="<?=$model->stir?>" data-type-id="<?=$model->type_id?>"
                                   data-viloyat-id="<?=$model->viloyat_id?>" data-adress="<?=$model->adress?>" data-special-code="<?=$model->special_code?>">
                                    <i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                                <a href="<?=Url::to("reestr/default/view/$model->id")?>" data-id="<?= $model->id ?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                                <a class="modal-delete-direction" type="button" data-id="<?= $model->id ?>" data-uk-modal="{target:'#modal_delete'}"><i class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a>
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
<?Pjax::end()?>
    <!--- Modal New Direction Add -->
    <div class="uk-modal" id="modal_add_reestr">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['id'=>'formDirection']); ?>
            <div class="uk-form-row">
                <?= $form->field($new, 'type_id')->dropDownList($type,['prompt'=>Uni::t("app", "Choose the activity type"),'tabindex' => 3
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'name_businesses')->textInput() ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'fio')->textInput() ?>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-3-4 uk-align-center">
                    <?= $form->field($new, 'rs')->textInput() ?>
                </div>
                <div class="uk-width-medium-1-4 uk-align-center">
                    <?= $form->field($new, 'stir')->textInput() ?>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-3-4 uk-align-center">
                    <?= $form->field($new, 'bank')->textInput() ?>
                </div>
                <div class="uk-width-medium-1-4 uk-align-center">
                    <?= $form->field($new, 'special_code')->textInput() ?>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-2-4 uk-align-center">
                    <?= $form->field($new, 'mfo')->textInput() ?>
                </div>
                <div class="uk-width-medium-2-4 uk-align-center">
                    <?= $form->field($new, 'oked')->textInput() ?>
                </div>
            </div>

            <div class="uk-grid" >
                <div class="uk-width-medium-2-4 uk-align-center">
                    <?= $form->field($new, 'viloyat_id')->dropDownList($map,['prompt'=>Uni::t("app", "Choose the region"),
                        'onchange'=>'
                        $.get("/reestr/default/listcity",{id: $(this).val()},function(response){
                            $("select#reestr-tuman_id").html(response);
                        });'
                    ])->label(false) ?>
                </div>
                <div class="uk-width-medium-2-4 uk-align-center">
                    <?= $form->field($new, 'tuman_id')->dropDownList([],['prompt'=>' - ',
                    ])->label(false) ?>
                </div>
            </div>

            <div class="uk-form-row">
                <?= $form->field($new, 'adress')->textInput() ?>
            </div>
            <!--            <input type="hidden" id="directionAdd"/>-->
            <br/>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-2-4 uk-align-center">
                    <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveDirection']) ?>
                    <?php Form::end(); ?>
                </div>
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
                <?= $form->field($new, 'name_businesses')->textInput(['id' => 'name_businesses']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'type_id')->dropDownList($type,['prompt'=>Uni::t("app", "Choose the activity type"),'id' => 'type_id'
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'stir')->textInput(['id' => 'stir']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'viloyat_id')->dropDownList($map,['prompt'=>Uni::t("app", "Choose the region"),
                    'onchange'=>'
                        $.get("/reestr/default/listcity",{id: $(this).val()},function(response){
                            $("select#tuman_id").html(response);
                        });','id' => 'viloyat_id'
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'tuman_id')->dropDownList([],['prompt'=>' - ','id' => 'tuman_id'
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'adress')->textInput(['id' => 'adress']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($new, 'special_code')->textInput(['id' => 'special_code']) ?>
            </div>

            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveDirectionEdit']) ?>
            <?php Form::end(); ?>
        </div>
    </div>
<?php
$this->registerJs('

     $(\'.modal-delete-direction\').click(function(){
        var pk=$(this).attr("data-id");
        var url=\'../default/delete/\'+pk;
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