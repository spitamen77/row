<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 28.12.2018 10:58
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
\app\components\widgets\SweetAlertAsset::register($this);

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Vaccine')." | ".$prixod->tumprixod->nomer;
//var_dump($prixod->user); die;
?>
    <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back();"><?=Uni::t('app','Back')?></a>
                <!-- <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button> -->
            </div>
            <div class="uk-width-1-2">
<!--                <form method="get">-->
<!--                    <div class="uk-grid">-->
<!--                        <div class="uk-width-3-4">-->
<!--                            <input class="md-input" placeholder="--><?//=Uni::t('app', 'Search')?><!--..." --><?//=$q?" value='".$q."'":""?><!-- name="q" type="text">-->
<!--                        </div>-->
<!--                        <div class="uk-width-1-4">-->
<!--                            <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->
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
                        <div class="uk-width-large-1-3">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Prixod name')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <span class="uk-text-large uk-text-middle"><?=$prixod->prixod->name?></span>
                                </div>
                            </div>
                            <hr class="uk-grid-divider">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Vaksina name')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <span class="uk-text-large uk-text-middle"><?=$prixod->vaksina->name?></span>
                                </div>
                            </div>
                            <hr class="uk-grid-divider">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Unit')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <?=$prixod->vaksina->unit->name?>
                                </div>
                            </div>
                            <hr class="uk-grid-divider uk-hidden-large">
                        </div>
                        <div class="uk-width-large-1-3">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Distributor')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <span class="uk-text-large uk-text-middle"><?=($prixod->user)?$prixod->user->makeFIO():Uni::t('app', 'Not set')?></span>
                                </div>
                            </div>
                            <hr class="uk-grid-divider">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Created date')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <span class="uk-text-large uk-text-middle"><?=date('d-m-Y', $prixod->created_at)?></span>
                                </div>
                            </div>
                            <hr class="uk-grid-divider">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Nomer')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <?=$prixod->nomer?>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-large-1-3">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Phone')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <span class="uk-text-large uk-text-middle"><?=($prixod->user)?$prixod->user->phone:Uni::t('app', 'Not set')?></span>
                                </div>
                            </div>
                            <hr class="uk-grid-divider">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Email')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <span class="uk-text-large uk-text-middle"><a href="mailto:<?=($prixod->user)?$prixod->user->email:""?>"><?=($prixod->user)?$prixod->user->email:Uni::t('app', 'Not set')?></a></span>
                                </div>
                            </div>
                            <hr class="uk-grid-divider">
                            <div class="uk-grid uk-grid-small">
                                <div class="uk-width-large-1-3">
                                    <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Tum prixod')?></span>
                                </div>
                                <div class="uk-width-large-2-3">
                                    <?=$prixod->tumprixod->nomer?>
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
                                <span class="md-list-heading uk-text-large uk-text-success"><?=$prixod->vaksina_miqdor?></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','Tarqatilgan')?></span>
                                <span class="md-list-heading uk-text-large uk-text-success"><?=$prixod->ostatok?></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="uk-text-small uk-text-muted uk-display-block"><?=Uni::t('app','Qoldiq')?></span>
                                <span class="md-list-heading uk-text-large uk-text-success"><?=$prixod->vaksina_miqdor-$prixod->ostatok?></span>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="md-card">
        <div class="md-card-content">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10"><?= Uni::t('app', 'User') ?></th>
                    <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Vaksina miqdor') ?></th>
                    <th class="uk-width-1-10 uk-text-left"><?= Uni::t('app', 'Vaksina qoldiq') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Number') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Created') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                    <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($query)) $viloyat->models = $query->models; ?>
                <?php if (!empty($viloyat->models)): ?>
                    <? foreach ($viloyat->models as $model) { /*var_dump($model); die;*/ ?>
                        <tr id='row_<?=$model->id?>' >

                            <td class="uk-text-center uk-table-middle small_col">
                                <input type="checkbox" data-md-icheck class="check_row"/>
                            </td>
                            <td class="uk-width-2-10 "><?= $model->hayvon_egasi ?></td>
                            <td class="uk-width-1-10 uk-text-left"><?=$model->vaksina_miqdor?></td>
                            <td class="uk-width-1-10 uk-text-left"><?=$model->real_miqdor?></td>
                            <td class="uk-width-2-10 uk-text-center"><?=$model->hayvonTuri->name?></td>
                            <td class="uk-width-1-10 uk-text-center"><?=date('d-m-Y', $model->created_at)?></td>
                            <td class="uk-width-1-10 uk-text-center">
                                <?if($model->status==0){?>
                                    <span class="uk-badge uk-badge-info"><?=Uni::t('app','Not seen')?></span>
                                <?}elseif($model->status==1){?>
                                    <span class="uk-badge uk-badge-success"><?=Uni::t('app','Accepted')?></span>
                                <?}elseif($model->status==2){?>
                                    <span class="uk-badge uk-badge-danger"><?=Uni::t('app','Denied')?></span>
                                <?}?>
                            </td>
                            <td class="uk-text-center">
                                <a type="button" href="<?=Url::to("vaksinatsiya/vaksina/uchastka/$model->vaksina_id/$model->uchastka_id")?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                            </td>
                        </tr>

                    <? } ?>

                <?php endif; ?>
                </tbody>
            </table>


        </div>
    </div>

<?= uni\widgets\LinkPager::widget([
    'pagination' => $viloyat->pagination,
    'options'=>['class' => 'uk-pagination']
]) ?>