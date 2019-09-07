<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 10.12.2018 12:30
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

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app','Laboratory')." | ".Uni::t('app', 'Arrival');
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

//var_dump($model->tuman->name); die;
?>
<style>
    canvas{
        max-width: none!important;
    }
</style>
 <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
                <button id="modal_add_direction_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app', 'Add arrival')?></button>
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
                            <span class="uk-text-muted uk-text-small"><?=Uni::t('app','User')?></span>
                        </div>
                        <div class="uk-width-large-2-3">
                            <span class="uk-text-large uk-text-middle"><a href="#"><?=isset($model->uchastka)?$model->uchastka->makeFIO():"not found"?></a></span>
                        </div>
                    </div>
                    <hr class="uk-grid-divider">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-large-1-3">
                            <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Kasal name')?></span>
                        </div>
                        <div class="uk-width-large-2-3">
                            <span class="uk-text-large uk-text-middle"><?=isset($model->kasal)?$model->kasal->name_uz:"not found"?></span>
                        </div>
                    </div>
                    <hr class="uk-grid-divider">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-large-1-3">
                            <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Kasal darajasi')?></span>
                        </div>
                        <div class="uk-width-large-2-3">
                            <?=$model->kasal_daraja?>
                        </div>
                    </div>
                    <hr class="uk-grid-divider">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-large-1-3">
                            <span class="uk-text-muted uk-text-small"><?=Uni::t('app','Created date')?></span>
                        </div>
                        <div class="uk-width-large-2-3">
                            <span class="uk-text-large uk-text-middle"><?=date("d-m-Y",$model->created_date)?></span>
                        </div>
                    </div>
                    <hr class="uk-grid-divider uk-hidden-large">
                </div>
                <div class="uk-width-large-1-2">
                    <p>
                        <span class="uk-text-muted uk-text-small uk-display-block uk-margin-small-bottom"><?=Uni::t('app','Manzil')?></span>
                        <?if(Uni::$app->access('LAB')||Uni::$app->access('ADMIN')||Uni::$app->access('HEAD')){if($model->viloyat)echo $model->viloyat->name.", "; if ($model->tuman)echo $model->tuman->name;}?>, <?=$model->manzil?>
                    </p>
                    <hr class="uk-grid-small"/>
                    <p>
                        <span class="uk-text-muted uk-text-small uk-display-block uk-margin-small-bottom"><?=Uni::t('app','Xulosa')?></span>
                        <?=$model->xulosa?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="uk-width-xLarge-3-10 uk-width-large-4-10">
    <div class="md-card">
        <div class="md-card-toolbar">
            <h3 class="md-card-toolbar-heading-text">
                <?=Uni::t('app','Photo')?>
            </h3>
        </div>
        <div class="md-card-content">
            <div class="uk-margin-bottom uk-text-center">
                <?if(file_exists(\uni\helpers\Url::base("https")."/files/upload/".$model->hayvon_rasm)){?>
                <img src="/files/upload/<?=$model->hayvon_rasm?>" with="50%" alt="" class="img_medium">
                <?}else{?>
                    <img src="/files/default/diagnose.png" width="50%"/>
                <?}?>
            </div>
        </div>
    </div>
</div>
</div>



<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-5-10">
        <div class="md-card">
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
    <div class="uk-width-medium-5-10">
        <div class="md-card">
            <div class="md-card-content">
                <ul class="md-list md-list-addon md-list-right">
                    <span class="md-list-heading"><?=Uni::t('app','Xulosa')?></span>
                    <?php foreach ($model->xulosaga as $item):?>
                    <li>
                        <div class="md-list-addon-element">
                            <?php if($item->fayl!=null){?>
                                <a href="<?=Url::to('laboratory/default/download/'.$item->id)?>" target="_blank">
                                <i class="md-list-addon-icon material-icons"></i></a>
                            <?}else{?>
                                <!-- <i class="md-list-addon-icon material-icons"></i></a> -->
                            <?} ?>
                        </div>
                        <div class="md-list-content">
                            <span class="uk-text-small uk-text-muted"><?=$item->user->makeFIO()?> (<?=$item->created_date?>)</span>
                            <span class="uk-text-small uk-text-muted"><?=$item->matn?></span>
                        </div>
                    </li>
                    <?php endforeach;?>

                </ul>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php $form = \uni\ui\Form::begin(['action'=>'/laboratory/default/save','id' => 'form_id','options' => ['enctype'=>'multipart/form-data']]);?>
                <!-- <form id="formLaboratorySave" enctype="multipart/form-data" method="post" action="<?=Url::to('laboratory/default/save')?>"> -->
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-2-2 uk-row-first">
                        <h3 class="heading_a uk-margin-medium-bottom"><?=Uni::t('app','Conclusion')?></h3>
                        <div class="uk-form-row">
                            <div class="md-input-wrapper md-input-filled"><label><?=Uni::t('app','Conclusion text')?></label>
                                <textarea cols="30" rows="4" class="md-input selecize_init" name="DiagnozXulosa[matn]"></textarea>
                                <span class="md-input-bar "></span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="uk-width-2-2">
                        <div id="file_upload-drop" class="uk-file-upload">
                            <!-- <p class="uk-text"><?#=Uni::t('app','Drop file to upload')?></p> -->
                            <!-- <p class="uk-text-muted uk-text-small uk-margin-small-bottom"><?#=Uni::t('app','or')?></p> -->
                            <a class="uk-form-file md-btn"><?=Uni::t('app','choose file')?><input id="file_upload-select" type="file" name="DiagnozXulosa[fayl]"></a>
                            <input id="diagnoz_id" value="<?=$model->id?>" type="hidden" name="DiagnozXulosa[diagnoz_id]">
                        </div>

                    </div>
                    <br>
                     <button class="md-btn md-btn-primary md-btn-block md-btn-wave-light waves-effect waves-button waves-light" type="submit" name="colcsave" ><?=Uni::t('app','Submit')?></button>
                    <?\uni\ui\Form::end() ?>
            </div>
        </div>
    </div>
</div>
<?
$this->registerJs('
    $(".colcsavze").click(function(){
        var data=$("#formLaboratorySave").serialize();
            $.post("/laboratory/laboratory/save",{data:data},function(response){
                if(response.status == "successEditLoad"){
                    window.location.reload();
                }
            });
    });
');
?>