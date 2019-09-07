<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 13.12.2018 16:15
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\components\manager\Url;
use app\models\Lang;
use uni\helpers\Html;
use uni\ui\Form;
use uni\widgets\Pjax;


\app\assets\DashboardAssets::register($this);
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Vaksina.saveVkTuman();Vaksina.openClearedVkTuman();Vaksina.openVkTumanForm();');

$current = Lang::getCurrent();
if ($current->url=='ru') $name = "name_ru"; else $name = "name_uz";
$viloyat = \app\models\Viloyat::findOne($userId);
$this->title = $viloyat->$name." - ".Uni::t('app','VetControl');
//$languages=\app\models\Lang::find()->all();
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
                <div class="uk-width-medium-1-10">
                    <a class="md-btn md-btn-success uk-margin-small-top" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
                </div>
<!--                <div class="uk-width-medium-2-10">-->
<!--                    <button id="modal_add_VkTuman_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-primary uk-margin-small-top" >--><?//=Uni::t('app','Add')?><!--</button>-->
<!--                </div>-->
                <div class="uk-width-medium-7-10">
                    <?Pjax::begin(['id'=>'filterData'])?>
                    <?Form::begin(['id'=>'filterForm','method'=>'get','action'=>Url::getMain(),'options' => ['class' => '', 'data-pjax' => true]])?>
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-3-10">
                            <div class="uk-margin-small-top">
                                <select name="region" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?=Uni::t('app',"City")?></option>
                                    <? foreach (\app\models\Tuman::find()->where(['viloyat_id'=>$userId])->all() as $v) { ?>

                                        <option value="<?=$v->id?>"><?=$v->name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-3-10">
                            <label for="product_search_name"><?=Uni::t('app',"Vaccine name")?></label>
                            <input name="name" type="text" class="md-input" id="product_search_name">
                        </div>
                        <div class="uk-width-medium-2-10">
                            <label for="product_search_name"><?=Uni::t('app',"Prixod name")?></label>
                            <input name="name" type="text" class="md-input" id="product_search_name">
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
                                    <td><?=$value->tuman->name?></td>
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
                                    <td><a href="<?=Url::to("settings/viloyat/tuman/$value->tuman_id")?>"><i class="md-icon material-icons uk-text-primary eye"></i></a></td>
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
    <div class="uk-modal" id="modal_add_VkTuman">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkTuman']); ?>
            <div class="uk-form-row">
                <?= $form->field($m, 'tuman_id')->dropDownList($tuman,['prompt'=>Uni::t("app", "Choose the city"),'tabindex' => 1
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina,['prompt'=>Uni::t("app", "Choose the vaccine"),'tabindex' => 2,
                    'onchange'=>'
                        $.get("/settings/viloyat/listcity",{id: $(this).val()},function(response){
                            $("select#vktuman-vil_prixod").html(response);
                        });'
                ])->label(false) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vil_prixod')->dropDownList([],['prompt'=>Uni::t("app", "Vaccine number"),'tabindex' => 3
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
                <?= $form->field($m, 'vaksina_date')->textInput(['tabindex' => 6,'data-uk-datepicker'=>'{format:\'DD.MM.YYYY\'}'])->label(Uni::t('app', 'Select date')) ?>
            </div>
            <input type="hidden" id="VkTumanAdd"/>
            <input type="hidden" name="Vktuman[viloyat_id]" value="<?=$userId?>" />
            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveVkTuman']) ?>
            <?php Form::end(); ?>
        </div>
    </div>


    <!--  Modal Notification after adding New VkVaksina -->
    <div class="uk-modal" id="modal_notificationVkTuman">
        <div class="uk-modal-dialog" style="min-height: 400px">
            <button type="button" class="uk-modal-close uk-close"></button>
            <a class="md-btn md-btn-primary" href='<?=Url::to('users/default/viloyat')?>'><?=Uni::t('app','Vaksina list')?></a>
            <button class="md-btn md-btn-primary" id='addAnotherVkTuman'><?=Uni::t('app','Add')?></button>
        </div>
    </div>

    <!--  Modal valid Notification after adding New VkVaksina -->
    <div class="uk-modal" id="modal_validVkTuman">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <br>
            <h3>Qiymatni kiritishda xatolik mavjud. kiritilgan qiyman umumiy qoldiq qiymatdan kop miqdorda</h3>
            <br><br>
            <button class="md-btn md-btn-default"><?=Uni::t('app','Close')?></button>
            <button class="md-btn md-btn-primary" id='addAnotherVkTuman'><?=Uni::t('app','Add')?></button>
        </div>
    </div>


    <!---   Modal VkVaksina Edit -->
    <div class="uk-modal" id="modal_edit_VkTuman">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formVkTumanEdit']); ?>
            <div class="uk-form-row">
                <?= $form->field($m, 'tuman_id')->dropDownList($tuman, ['id' => 'dir-tuman']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_id')->dropDownList($vaksina, ['id' => 'dir-vaksina']) ?>
            </div>
            <div class="uk-form-row">
                <?= $form->field($m, 'vaksina_miqdor')->textInput(['id' => 'dir-miqdor']) ?>
            </div>


            <br/>
            <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveVkTumanEdit']) ?>
            <?php Form::end(); ?>
        </div>
    </div>

    <!--  Modal VkVaksina after deletion -->
    <div class="uk-modal" id="modal_deleteVkTuman">
        <div class="uk-modal-dialog" style="min-height: 400px">
            <button type="button" class="uk-modal-close uk-close"></button>
            <a class="md-btn md-btn-primary"><?=Uni::t('app','Back to List')?></a>
            <button class="md-btn md-btn-primary" id='deleteAnotherVkTuman'><?=Uni::t('app','Confirm')?></button>
        </div>
    </div>

<?php
$this->registerJs('
    $( "select#vktuman-vaksina_id" ).change(function() {
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