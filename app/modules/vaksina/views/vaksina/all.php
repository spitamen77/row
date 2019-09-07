<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 26.12.2018 12:41
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;
use uni\widgets\Pjax;

\app\components\widgets\SweetAlertAsset::register($this);
$this->title = Uni::t('app', 'Vaccine') . " | " . Uni::t('app', "All vaccine");
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
                <div class="uk-width-medium-2-10">
                    <a class="md-btn md-btn-success md-btn-small"
                       href="<?= Url::to('vaksinatsiya') ?>"><?= Uni::t('app', 'Back') ?></a>
                </div>
                <? Pjax::begin(['id' => 'filterData']) ?>
                <? Form::begin(['id' => 'filterForm', 'method' => 'get', 'action' => Url::getMain(), 'options' => ['class' => '', 'data-pjax' => true]]) ?>
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-2-10">
                        <label for="product_search_name"><?= Uni::t('app', "Address") ?></label>
                        <input name="address" type="text" class="md-input" id="product_search_name">
                    </div>
                    <div class="uk-width-medium-2-10">
                        <div class="uk-margin-small-top">
                            <select name="vk_turi" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?= Uni::t('app', "Vaccine category") ?></option>
                                <? foreach (\app\models\Vaksina::find()->all() as $v) { ?>

                                    <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-10">
                        <label for="product_search_name"><?= Uni::t('app', "Owner") ?></label>
                        <input name="owner" type="text" class="md-input" id="product_search_name">
                    </div>

                    <div class="uk-width-medium-2-10">
                        <div class="uk-margin-small-top">
                            <select name="hayvon_turi" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?= Uni::t('app', "Animal type") ?></option>
                                <? foreach (\app\models\HayvonTuri::find()->where(['status' => 1])->all() as $v) { ?>

                                    <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-10">
                        <div class="uk-margin-small-top">
                            <select name="hayvon_rangi" data-md-selectize data-md-selectize-bottom>
                                <option value=""><?= Uni::t('app', "Animal color") ?></option>
                                <? foreach (\app\models\HayvonRangi::find()->where(['status' => 1])->all() as $v) { ?>

                                    <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-10 uk-text-center">
                        <button type="submit"
                                class="md-btn md-btn-primary uk-margin-small-top"><?= Uni::t('app', "Filter") ?></button>
                    </div>

                </div>
                <? Form::end() ?>
                <? Pjax::end() ?>
            </div>
        </div>
    </div>


<? Pjax::begin(['id' => 'listData']) ?>
    <div class="md-card">
        <div class="md-card-content">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>
                <tr>
                    <th class="uk-width-1-10"><?= Uni::t('app', 'Photo') ?></th>
                    <th class="uk-width-2-10"><?= Uni::t('app', 'Address') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Vaccine name') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Vaccine count') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Animal type') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Animal color') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Owner') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Date') ?></th>
                    <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->models as $item): ?>

                    <tr>
                        <td>
                            <? if (file_exists(Uni::getAlias("root") . "/files/upload/" . $item->hayvon_rasm)) { ?>
                                <img src="/files/upload/<?= $item->hayvon_rasm ?>" alt="" class="img_medium"
                                     width="80px">
                            <? } else { ?>
                                <img src="/files/default/diagnose.png" width="80px"/>
                            <? } ?>
                        </td>
                        <td><?= $item->manzil ?></td>
                        <td><?= ($item->vaksina) ? $item->vaksina->name : "" ?></td>
                        <td class="uk-text-center"><?= $item->vaksina_miqdor ?></td>
                        <td class="uk-text-center"><?= ($item->hayvonTuri) ? $item->hayvonTuri->name : "" ?></td>
                        <td class="uk-text-center"><?= ($item->hayvonRangi) ? $item->hayvonRangi->name : "" ?></td>
                        <td class="uk-text-center"><?= $item->hayvon_egasi ?>
                        </td>
                        <td class="uk-text-center"><?= date('d-m-Y', $item->created_at) ?></td>
                        <td class="uk-text-center"><a href="<?= Url::to("vaksinatsiya/vaksina/perform/$item->id") ?>"
                                                      data-id="<?= $item->id ?>"><i
                                        class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!--        <h3 class="uk-text-center"><a href="--><? //= Url::to('vaksinatsiya/default/all') ?><!--">-->
            <? //= Uni::t('app', 'View all') ?><!--</a>-->
            <!--        </h3>-->
        </div>
    </div>
<? Pjax::end() ?>