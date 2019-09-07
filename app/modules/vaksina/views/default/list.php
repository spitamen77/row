<?
$this->title = Uni::t('app','VetControl');

//\app\assets\DashboardAssets::register($this);
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Viloyat;
use app\models\Vaksina;
use app\models\VkViloyat;

//$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}


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
                                <span class="uk-text-large uk-text-middle"><a href="#"><?=$vaksina->name_uz?></a></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Vaksina name')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$vaksina->name_uz?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Unit')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$vaksina->unit->name_uz?>
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
                                <span class="uk-text-large uk-text-middle"><a href="#"><?=$vaksina->user->makeFIO()?></a></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Created date')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=date('d-m-Y', $vaksina->created_date)?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Number')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$vaksina->name_uz?>
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
                            <span class="md-list-heading uk-text-large uk-text-success"><?=$vaksina->count?></span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','Tarqatilgan')?></span>
                            <span class="md-list-heading uk-text-large uk-text-success"><?#=$vaksina->count-$vaksina->ostatok?></span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','Qoldiq')?></span>
                            <span class="md-list-heading uk-text-large uk-text-success"><?#=$vaksina->ostatok()?></span>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>






<div class="md-card">
    <div class="md-card-content">
        <h2><?=Uni::t('app', 'Administration panel')?></h2>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover">
                    <thead>
                    <tr>
                        <th><?=Uni::t('app', 'Prixod name')?></th>
                        <th><?=Uni::t('app', 'Vaccine count')?></th>
                        <th><?=Uni::t('app', 'Vaccine used')?></th>
                        <th><?=Uni::t('app', 'Vaccine residue')?></th>
                        
                        <th><?=Uni::t('app', 'Status')?></th>
                        <th>---</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($data as $value) : ?>
                    <tr>
                        <td><?=$value->name_uz?></td>
                        <td><?=$value->count." ".$value->unit->name_uz?></td>
                        <td><?=($value->count-$value->ostatok)." ".$value->unit->name_uz?></td>
                        <td><?=$value->ostatok." ".$value->unit->name_uz?></td>
                        <td><?=$value->status?></td>

                        <td><a  href="<?=Url::to("vaksinatsiya/default/view/".$value['id'])?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a></td>

                    </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

