<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
$this->title = Uni::t('app','Users list');
\app\components\widgets\SweetAlertAsset::register($this);
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$v = \app\models\Viloyat::findOne(Uni::$app->getUser()->identity->personal->viloyat_id);
?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('settings/vktuman/prixod')?>"><?=Uni::t('app','Prixod')?></a>
        <a class="md-btn md-btn-success md-btn-small" href="<?=$this->to('settings/vktuman/accepted')?>"><?=Uni::t('app','Accepted')?></a>
        <a class="md-btn md-btn-danger md-btn-small" href="<?=$this->to('settings/vktuman/denied')?>"><?=Uni::t('app','Denied')?></a>
        </div>
        <div class="uk-width-1-2">
            <form method="get">
                <div class="uk-grid">
                    <div class="uk-width-3-4">
                        <input class="md-input" placeholder="<?=Uni::t('app','Search')?>" <?=$q?" value='".$q."'":""?> name="q" type="text">
                    </div>
                    <div class="uk-width-1-4">
                        <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="md-card">
    <div class="md-card-toolbar"><p></p>
    <h3><?=$v->name_uz?>: <?=$this->title?></h3>
</div>
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10"><?=Uni::t('app','Prixod name')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Vaccine')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Amount of vaccine')?></th>
                    <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','Created date')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Status')?></th>
                    
                </tr>
                </thead>
                <tbody>
                
                <?php foreach ($dataProvider->models as $model) {?>
                    <tr id="row_<?=$model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td><?=$model->prixod_id?></td>
                        <td class="uk-text-left"><?=$model->vaksina->name_uz?></td>
                        <td class="uk-text-left"><?=$model->vaksina_miqdor?></td>
                        <td class="uk-text-center"><?=date('d-m-Y',$model->created_date)?></td>
                        <td class="uk-text-center">
                            <span type="button" class="uk-badge uk-badge-danger"><?=Uni::t('app','Denied')?></span>
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