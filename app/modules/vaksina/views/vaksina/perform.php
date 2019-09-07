<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 26.12.2018 10:47
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
\app\components\widgets\SweetAlertAsset::register($this);
\app\assets\MapAssets::register($this);
$this->registerJs('
        var map = L.map("map");

        $.getJSON("/data/maps/uz.json").then(function(geoJSON) {
          var osm = new L.TileLayer.BoundaryCanvas("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            boundary: geoJSON,
            attribution: "&copy;contributors, VIS.UZ"
          });
          map.addLayer(osm);
          var ukLayer = L.geoJSON(geoJSON);
          map.fitBounds(ukLayer.getBounds());
        });
        var pulsingIcon = L.icon.pulse({iconSize:[14,14],color:"red"});
        var pulsingIcon3 = L.icon.pulse({iconSize:[12,12],color:"green"});
        L.marker(['.$model->location_latitude.','.$model->location_longitude.'],{icon: pulsingIcon3,title: "This is pulsing icon"}).addTo(map);
');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Vaccine')." | ".Uni::t('app', 'Vaccine perform');
?>
<style>
    canvas{
        max-width: none!important;
    }
</style>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
            <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back();"><?=Uni::t('app','Back')?></a>
            <!-- <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button> -->
        </div>
<!--        <div class="uk-width-1-2">-->
<!--            <form method="get">-->
<!--                <div class="uk-grid">-->
<!--                    <div class="uk-width-3-4">-->
<!--                        <input class="md-input" placeholder="--><?//=Uni::t('app', 'Search')?><!--..." --><?//=$q?" value='".$q."'":""?><!-- name="q" type="text">-->
<!--                    </div>-->
<!--                    <div class="uk-width-1-4">-->
<!--                        <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
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
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Owner')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$model->hayvon_egasi?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Address')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$model->manzil?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Vaksina type')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$model->vaksina->name?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Count')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$model->vaksina_miqdor?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Real count')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=$model->real_miqdor?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <?if(file_exists(Uni::getAlias("root")."/files/upload/".$model->hayvon_rasm)){?>
                            <img src="/files/upload/<?=$model->hayvon_rasm?>" alt="" class="img_medium">
                        <?}else{?>
                            <img src="/files/default/diagnose.png"/>
                        <?}?>
                        <hr class="uk-grid-divider uk-hidden-large">
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Distributor')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=$model->uchastka_id?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Created date')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <span class="uk-text-large uk-text-middle"><?=date('d-m-Y', $model->created_at)?></span>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Animal type')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=($model->hayvonTuri)?$model->hayvonTuri->name:""?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Animal color')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=($model->hayvonRangi)?$model->hayvonRangi->name:""?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="uk-grid uk-grid-small">
                            <div class="uk-width-large-1-3">
                                <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Status')?></span>
                            </div>
                            <div class="uk-width-large-2-3">
                                <?=($model->status==1)? Uni::t('app', 'Active'): Uni::t('app', 'Not active')?>
                            </div>
                        </div>
                        <hr class="uk-grid-divider">
                        <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                <a target="_blank" title="<?=$model->manzil?>" href="https://www.google.com/maps/place/<?=$model->location_latitude?>,<?=$model->location_longitude?>">
                                    <?=Uni::t('app','Map link')?> <i class="md-icon material-icons" ></i></a>
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                <?=$model->manzil?> <span class="route_km">(0km)</span>
                            </h3>
                        </div>
                        <div class="md-card-content">
                            <div id="map" style="height: 400px" > </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

