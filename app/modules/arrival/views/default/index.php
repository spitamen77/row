<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
$this->title = Uni::t('app','Drugs list');
\app\components\widgets\SweetAlertAsset::register($this);

?>
<div class="md-card">
    <div class="md-card-content">
        <form method="get">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-3-10">
                <a href="<?=$this->to('preparat/default/add')?>" class="md-btn md-btn-warning uk-margin-small-top"><?=Uni::t('app','Add')?></a>
            </div>
            <div class="uk-width-medium-2-10">
                <label for="product_search_name"><?=Uni::t('app',"Drug name")?></label>
                <input name="name" type="text" class="md-input" id="product_search_name">
            </div>

            <div class="uk-width-medium-2-10">
                <div class="uk-margin-small-top">
                    <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                        <option value=""><?=Uni::t('app',"Drup category")?></option>
                        <option value="1">Andijon</option>
                        <option value="2">Samarqand</option>
                        <option value="3">Toshkent</option>
                    </select>
                </div>
            </div>
            <div class="uk-width-medium-1-10">
                <div class="uk-margin-top uk-text-nowrap">
                    <input type="checkbox" name="product_search_active" id="product_search_active" data-md-icheck/>
                    <label for="product_search_active" class="inline-label"><?=Uni::t('app',"Active")?></label>
                </div>
            </div>
            <div class="uk-width-medium-2-10 uk-text-center">
                <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?=Uni::t('app',"Filter")?></button>
            </div>
        </div>
        </form>
    </div>
</div>


<div class="md-card">
    <div class="md-card-toolbar"><p></p>
        <h3><?=$this->title?></h3>

    </div>
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all">
                    </th>
                    <th class="uk-width-2-10"><?=Uni::t('app','Name in russia')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Name in uzbek')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Category')?></th>
                    <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Dosage')?></th>
                    <th class="uk-width-2-10 uk-text-center" style="width: 70px"><?=Uni::t('app','Added date')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Actions')?></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($dataProvider->models as $model) {?>
                    <tr id="row_<?=$model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-text-left"><?=$model->name_ru?></td>
                        <td class="uk-text-left"><?=$model->name_uz?></td>
                        <td class="uk-text-left"><?#=($model->turi)?$model->turi->name:""?></td>
                        <td class="uk-text-left">
                            <?=($model->mol)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Large horned')." : ".$model->mol."</span>":""?>
                            <?=($model->qoy)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Small horned')." : ".$model->qoy."</span><br/>":""?>
                            <?=($model->tovuq)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Poultry')." : ".$model->tovuq."</span>":""?>
                            <?=($model->mushuk)?'<span class="uk-badge uk-badge-primary">'.Uni::t('app','Pets')." : ".$model->mushuk."</span><br/>":""?>
                        </td>

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