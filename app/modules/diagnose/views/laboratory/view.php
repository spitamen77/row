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

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app','Diagnose&Prevention')." | ";
?>
 <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('settings/arrival/index')?>"><?=Uni::t('app','All')?></a>
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
                            <span class="uk-text-large uk-text-middle"><?=$model->created_date?></span>
                        </div>
                    </div>
                    <hr class="uk-grid-divider uk-hidden-large">
                </div>
                <div class="uk-width-large-1-2">
                    <p>
                        <span class="uk-text-muted uk-text-small uk-display-block uk-margin-small-bottom"><?=Uni::t('app','Manzil')?></span>
                        <?=$model->manzil?>
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
                <img src="/files/img/cow.jpg" alt="" class="img_medium">
            </div>
        </div>
    </div>
</div>
</div>



<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-10-10">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    Styled map (neutral blue)
                </h3>
            </div>
            <div class="md-card-content">
                <div id="gmap_style_a" class="gmap" style="width:100%;height:300px;"></div>
            </div>
        </div>
    </div>
</div>
