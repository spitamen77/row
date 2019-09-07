<?
$this->title = Uni::t('app','VetControl');

//\app\assets\DashboardAssets::register($this);
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Vaksina;
use app\models\VkViloyat;
use uni\widgets\Pjax;

\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Vaksina.saveVkViloyat();Vaksina.openClearedVkViloyat();Vaksina.openVkViloyatForm();Vaksina.openEditVkViloyatForm();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
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
                <button id="modal_add_VkViloyat_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-primary uk-margin-small-top" ><?=Uni::t('app','Add')?></button>
            </div>
            <div class="uk-width-medium-8-10">
                <?Pjax::begin(['id'=>'filterData'])?>
                <?Form::begin(['id'=>'filterForm','method'=>'get','action'=>Url::getMain(),'options' => ['class' => '', 'data-pjax' => true]])?>
                    <div class="uk-grid" data-uk-grid-margin="">
                         <div class="uk-width-medium-3-10">
                            <div class="uk-margin-small-top">
                                <select name="region" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?=Uni::t('app',"Region category")?></option>
                                    <? foreach (\app\models\Viloyat::find()->all() as $v) { ?>

                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-3-10">
                            <select name="vac_name" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?=Uni::t('app',"Vaccine name")?></option>
                                <? foreach (\app\models\Vaksina::find()->where(['status'=>1])->all() as $v) { ?>

                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="uk-width-medium-2-10">
                            <select name="pri_name" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?=Uni::t('app',"Prixod name")?></option>
                                <? foreach (\app\models\Prixod::find()->where(['status'=>1])->all() as $v) { ?>

                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="uk-width-medium-2-10 uk-text-center">
                            <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                        </div>
                    </div>
                <?php Form::end()?>
                <? Pjax::end()?>
            </div>
        </div>
    </div>
</div>



<?Pjax::begin(['id'=>'listData'])?>
<br>
<div class="uk-grid">
    <div class="uk-width-2-2">
        <div class="md-card-content">

            <h2><?=Uni::t('app', 'Last distributions')?></h2>
        </div>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-hover">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th><?=Uni::t('app', 'Region name')?></th>
                            <th><?=Uni::t('app', 'Vaccine name')?></th>
                            <th><?=Uni::t('app', 'Vaccine count')?></th>
                            <th><?=Uni::t('app', 'Vaccine residue')?></th>
                            <th><?=Uni::t('app', 'Created date')?></th>
                            <th><?=Uni::t('app', 'Status')?></th>
                            <th><?=Uni::t('app', 'Actions')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach ($data->models as $value) :$i++; ?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?=$value->viloyat->name?></td>
                            <td><?=$value->vaksina->name?></td>
                            <td><?=$value->vaksina_miqdor?>-<?=$value->vaksina->unit->name?></td>
                            <td><?=$value->ostatok?>-<?=$value->vaksina->unit->name?></td>
                            <td><?=date("d-m-Y",$value->created_date)?></td>
                            <td><?php switch ($value->status) {
                                case 1:?>
        <span type="button" style="cursor: pointer;" class="uk-badge uk-badge-primary accept" id="accept" ><?=Uni::t('app', 'Accept')?></span>
        <?php break;
        case 0:?>
        <span type="button" style="cursor: pointer;" class="uk-badge uk-badge-danger deny" id="deny" ><?=Uni::t('app', 'Not accepted')?></span>
        <?php break;} ?>
        </td>
                            <td><a href="<?=Url::to("settings/viloyat/viloyat/".$value->viloyat->id)?>"><i class="md-icon material-icons uk-text-primary eye"></i></a></td>
                        </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                    <?= uni\widgets\LinkPager::widget([
                        'pagination' => $data->pagination,
                        'options'=>['class' => 'uk-pagination']
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? Pjax::end()?>

<!--- Modal New VkVaksina Add -->
<div class="uk-modal" id="modal_add_VkViloyat">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkViloyat']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'viloyat_id')->dropDownList($viloyat,['prompt'=>Uni::t("app", "Choose the region"),'tabindex' => 1
                    ])->label(false) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina,['prompt'=>Uni::t("app", "Choose the vaccine"),'tabindex' => 2,
                        'onchange'=>'
                        $.get("/settings/viloyat/list",{id: $(this).val()},function(response){
                            $("select#vkviloyat-proxod_id").html(response);
                        });'
                    ])->label(false) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'proxod_id')->dropDownList([],['prompt'=>' - ','tabindex' => 3
                    ])->label(false) ?>
                </div>
<!--                <div class="uk-form-row">-->
<!--                    --><?//= $form->field($m, 'vaksina_miqdor')->textInput(['tabindex' => 4]) ?>
<!--                </div>-->
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-2-4">
                        <?= $form->field($m, 'vaksina_miqdor')->textInput() ?>

                    </div>
                    <div class="uk-width-medium-2-4">
                        <label  class="md-input masked_input"><?=Uni::t('app', 'Unit measure')?> - <b id="prixod-ves"> - </b>, <?=Uni::t('app', 'Dose')?> - <b id="prixod-doza"></b></label>
                        <!--                    <input class="md-input masked_input" id="masked_phone" type="text">-->
                        <input type="hidden" id="prixod-count2" class="md-input" name="Prixod[unit_id]">
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

<!--  Modal Notification after adding New VkVaksina -->
<div class="uk-modal" id="modal_notificationVkViloyat">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('users/default/dashboard')?>'><?=Uni::t('app','Vaksina list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherVkViloyat'><?=Uni::t('app','Add')?></button> 
    </div>
</div>


<!---   Modal VkVaksina Edit -->
<div class="uk-modal" id="modal_edit_VkViloyat">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkViloyatEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'viloyat_id')->dropDownList($viloyat, ['id' => 'dir-viloyat']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina, ['id' => 'dir-vaksina']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'vaksina_miqdor')->textInput(['id' => 'dir-miqdor']) ?>
                </div>
                
                
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveVkViloyatEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal VkVaksina after deletion -->
<div class="uk-modal" id="modal_deleteVkViloyat">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary"><?=Uni::t('app','Back to List')?></a>
        <button class="md-btn md-btn-primary" id='deleteAnotherVkViloyat'><?=Uni::t('app','Confirm')?></button> 
    </div>
</div>
<?php
$this->registerJs('
    $( "select#vkviloyat-vaksina_id" ).change(function() {
    var x = $(this).val();
    $.get("/settings/viloyat/kg",{id: x},function(response){
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