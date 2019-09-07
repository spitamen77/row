<?

use app\components\manager\Url;
use uni\ui\Form;
use uni\widgets\Pjax;

$this->title = Uni::t('app', 'Diagnose&Prevention') . " | " . Uni::t('app', 'Diagnose list');
\app\components\widgets\SweetAlertAsset::register($this);
$q = false;
if (isset($_GET['q'])) {
    $q = $_GET['q'];
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

            <div class="uk-width-medium-8-10">
                <? Pjax::begin(['id' => 'filterData']) ?>
                <? Form::begin(['id' => 'filterForm', 'method' => 'get', 'action' => Url::getMain(), 'options' => ['class' => '', 'data-pjax' => true]]) ?>
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-3-10">
                        <div class="uk-margin-small-top">
                            <select id="kasal" name="kas" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?=Uni::t('app',"Disease name")?></option>
                                <? foreach ($disease as $item) { ?>

                                    <option value="<?=$item->kasal_id?>"><?= ($item->kasal) ? $item->kasal->name : "" ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-10">
                        <label for="product_search_price"><?= Uni::t('app', "Disease degree") ?></label>
                        <input type="text" name="degree" class="md-input" id="product_search_price">
                    </div>
                    <div class="uk-width-medium-3-10">
                        <div class="uk-margin-small-top">
                            <select name="vil" id="vil" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?=Uni::t('app',"Region category")?></option>
                                <? foreach (\app\models\Viloyat::find()->orderBy(['id'=>SORT_DESC])->all() as $v) { ?>

                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-2-10 uk-text-center">
                        <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
                    </div>
                </div>
                <? Form::end() ?>
                <? Pjax::end() ?>
            </div>
        </div>
    </div>
</div>


<div class="md-card">
    <div class="md-card-toolbar"><p></p>
        <h3><?= $this->title ?></h3>

    </div>
    <div class="md-card-content">
        <?Pjax::begin(['id'=>'listData'])?>
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col"><?= Uni::t('app', 'Photo') ?></th>

                    <th class="uk-width-2-10"><?= Uni::t('app', 'Disease name') ?></th>
                    <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Disease degree') ?></th>
                    <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Uchastka') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Address') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Created') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($dataProvider->models as $model) { ?>
                    <tr id="row_<?= $model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <? if (file_exists(Uni::getAlias("root") . "/files/upload/" . $model->hayvon_rasm)) { ?>
                                <img src="/files/upload/<?= $model->hayvon_rasm ?>" alt="" class="img_medium"
                                     width="80px">
                            <? } else { ?>
                                <img src="/files/default/diagnose.png" width="80px"/>
                            <? } ?>
                        </td>
                        <td class="uk-text-left"><?= ($model->kasal) ? $model->kasal->name : "" ?></td>
                        <td class="uk-text-left"><?= $model->kasal_daraja ?></td>
                        <td class="uk-text-left"><?= isset($model->uchastka) ? $model->uchastka->makeFIO() : "not found" ?></td>
                        <td class="uk-text-center"><?= ($model->viloyat)?$model->viloyat->name:"".", ".($model->tuman?$model->tuman->name:"").",<br>".$model->manzil ?></td>
                        <td class="uk-text-center"><?= date('d-m-Y',$model->created_date) ?></td>
                        <td class="uk-text-center">
                            <a href="<?= $this->to('laboratory/default/view/' . $model->id) ?>"><i
                                        class="md-icon material-icons uk-text-primary">&#xE417;</i></a>
                        </td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>

        <?= uni\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination
        ]) ?>
        <?Pjax::end()?>
    </div>
</div>
