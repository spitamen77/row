<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
use uni\ui\Form;
use app\models\Lang;
use uni\widgets\Pjax;
$this->title = Uni::t('app','Drugs list');
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.savePreparat();Muxr.dynamicFields();Muxr.openClearedDirection();Muxr.openDirectionForm();Muxr.openClearedPreparat();Muxr.openDeleteDirectionForm();Muxr.editVaksinaStatus();');

$current = Lang::getCurrent();
if ($current->url=="ru") $map = ArrayHelper::map($items,'id','name_ru');
else $map = ArrayHelper::map($items,'id','name_uz');
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
                <a id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}"  class="md-btn md-btn-warning uk-margin-small-top"><?=Uni::t('app','Add')?></a>
            </div>
            <div class="uk-width-medium-8-10">
            <?Pjax::begin(['id'=>'filterData'])?>
            <?Form::begin(['id'=>'filterForm','method'=>'get','action'=>Url::getMain(),'options' => ['class' => '', 'data-pjax' => true]])?>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-2-10">
                    <div class="uk-margin-small-top">
                        <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                            <option value=""><?=Uni::t('app',"Vaccine type")?></option>
                            <?php foreach ($hayvon as $item): ?>
                                <option value="<?=$item->id?>"><?= ($item->name)?$item->name:Uni::t('app',"Not set") ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="uk-width-medium-3-10">
                    <label for="product_search_name"><?=Uni::t('app',"Drug name")?></label>
                    <input name="name" type="text" class="md-input" id="product_search_name">
                </div>
                <div class="uk-width-medium-1-10">
                    <input type="checkbox" name="product_search_active" id="product_search_active" data-md-icheck/>
                    <label for="product_search_active" class="inline-label"><?=Uni::t('app',"Active")?></label>
                </div>
                <div class="uk-width-medium-1-10 uk-text-center">
                    <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                </div>
                <div class="uk-width-medium-1-10 uk-text-center">
                    <a href="<?=Url::to('preparat')?>"  class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Reset")?></a>
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

            <h2><?=$this->title?></h2>
        </div>
        <div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <div class="uk-overflow-container">

            <table class="uk-table uk-table-nowrap table_check uk-table-hover">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        №
                    </th>
                    <th class="uk-width-2-10"><?=Uni::t('app','Name in russia')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Name in uzbek')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Category')?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Unit') ?></th>
<!--                    <th class="uk-width-2-10 uk-text-center">--><?//=Uni::t('app','Dosage')?><!--</th>-->
                    <th class="uk-width-2-10 uk-text-center" style="width: 70px"><?=Uni::t('app','Added date')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Actions')?></th>
                </tr>
                </thead>
                <tbody>

                <?php $i=0; foreach ($dataProvider->models as $model) {$i++;?>
                    <tr id="row_<?=$model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <?=$i?>
                        </td>
                        <td class="uk-text-left"><?=$model->name_ru?></td>
                        <td class="uk-text-left"><?=$model->name_uz?></td>
                        <td class="uk-text-left"><?=($model->turi)?$model->turi->name:""?></td>
                        <td class="uk-width-2-10 uk-text-center"><?= $model->unit->name?></td>
<!--                        <td class="uk-text-left">-->
<!--                            --><?//=($model->mol)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Large horned')." : ".$model->mol."</span>":""?>
<!--                            --><?//=($model->qoy)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Small horned')." : ".$model->qoy."</span><br/>":""?>
<!--                            --><?//=($model->tovuq)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Poultry')." : ".$model->tovuq."</span>":""?>
<!--                            --><?//=($model->mushuk)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Pets')." : ".$model->mushuk."</span><br/>":""?>
<!--                        </td>-->

                        <td class="uk-text-center"><?=date("d-m-Y",$model->created_date)?></td>
                        <td class="uk-text-center">
                            <a href="<?=$this->to('preparat/default/view/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>
                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>

        </div>

        <?= uni\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination
        ]) ?>
    </div>
        </div>
    </div>
</div>
<?Pjax::end()?>
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
                <?= $form->field($new, 'name_ru')->textInput() ?>
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
                <select id="emlash_turi" class="md-input" name="emlash_turi">
                    <option value="0"><?=Uni::t('app', 'Profilaktik')?></option>
                    <option value="1"><?=Uni::t('app', 'Required')?></option>
                </select>
            </div>
            <div class="uk-width-medium-1-3">
                <input type="text" class="md-input" name="temperatura" id="temperatura" placeholder="<?=Uni::t('app', 'Temperature')?>">
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

<!--        <div class="uk-grid">-->
<!--            <div data-dynamic-fields="field_template_modal"></div>-->
<!--            <script id="field_template_modal" type="text/x-handlebars-template">-->
<!--                <div class="uk-grid form_section">-->
<!--                    <div class="uk-width-1-2">-->
<!--                        <div class="uk-input-group">-->
<!--                            <select class="md-input" id="hayvon{{counter}}" name="hay{{counter}}">-->
<!--                                --><?php //foreach ($hayvon as $item): ?>
<!--                                <option  value="--><?//=$item->id?><!--">--><?//= ($item->name)?$item->name:Uni::t('app',"Not set") ?><!--</option>-->
<!--                                --><?php //endforeach; ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="uk-width-1-2">-->
<!--                        <div class="uk-input-group">-->
<!--<!--                            <label for="address{{counter}}">--><?////=Uni::t('app', 'Fields')?><!--<!--</label>-->
<!--                            <input type="text" class="md-input" name="address{{counter}}" id="address{{counter}}">-->
<!--                            <span class="uk-input-group-addon">-->
<!--                                                    <a href="#" class="btnSectionClone"><i class="material-icons md-24">&#xE146;</i></a>-->
<!--                                                </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!---->
<!--                </div>-->
<!--            </script>-->
<!--        </div>-->

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
                <button class="md-btn md-btn-primary" id='addAnotherVkViloyat' ><?=Uni::t('app','Add')?></button>
    </div>
</div>