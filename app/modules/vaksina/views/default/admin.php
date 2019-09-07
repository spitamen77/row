<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 13.12.2018 19:57
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\assets\CoreAssets;
use app\models\Lang;
use app\models\Prixod;
use app\components\manager\Url;
use uni\ui\Form;
use uni\widgets\Pjax;

$q = false;
if (isset($_GET['q'])) {
    $q = $_GET['q'];
}
$current = Lang::getCurrent();
// if ($current->url=="ru") $map = ArrayHelper::map($items,'id','name_ru');
// else $map = ArrayHelper::map($items,'id','name_uz');
$this->title = Uni::t('app', 'Vaccine');

$this->registerJsFile('/../../themes/ui/components/d3/d3.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/components/c3js-chart/c3.min.js', ['depends' => [CoreAssets::className()]]);
//$this->registerJsFile('/../../themes/ui/assets/js/pages/plugins_charts.min.js', ['depends' => [CoreAssets::className()]]);

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

    <div class="uk-grid uk-margin-medium-bottom" data-uk-grid-margin="">
        <div class="uk-width-medium-3-3 uk-row-first">
            <h4 class="heading_a uk-margin-bottom"><?= Uni::t('app', 'Vaksinatsiya') ?></h4>
            <div class="md-card">
                <div class="md-card-content">
                    <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                        <li class="uk-width-1-3 uk-active" aria-expanded="true"><a
                                    href="#"><?= Uni::t('app', 'Received') ?></a></li>
                        <li class="uk-width-1-3" aria-expanded="false"><a
                                    href="#"><?= Uni::t('app', 'New arrival') ?></a>
                        </li>
                        <li class="uk-width-1-3" aria-expanded="false"><a href="#"><?= Uni::t('app', 'Canceled') ?></a>
                        </li>
                        <li class="uk-tab-responsive uk-active uk-hidden" aria-haspopup="true" aria-expanded="false">
                            <a><?= Uni::t('app', 'Active') ?></a>
                            <div class="uk-dropdown uk-dropdown-small" aria-hidden="true">
                                <ul class="uk-nav uk-nav-dropdown"></ul>
                                <div></div>
                            </div>
                        </li>
                    </ul>
                    <ul id="tabs_4" class="uk-switcher uk-margin">
                        <li aria-hidden="false" class="uk-active">
                            <div class="md-card-content">
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-table-nowrap uk-table-hover table_check">
                                        <thead>
                                        <tr>
                                            <th class="uk-width-2-10"><?= Uni::t('app', 'Arrival name') ?></th>
                                            <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Arrival number') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Arrival date') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (Prixod::getAccepted() as $item): ?>
                                            <tr>
                                                <td><?= (Uni::$app->language == 'ru') ? $item->name_ru : $item->name_uz; ?></td>
                                                <td class="uk-text-center"><?= $item->number ?></td>
                                                <td class="uk-text-center"><?= date('d-m-Y', $item->prixod_date) ?></td>
                                                <td class="uk-text-center"><span
                                                            class="uk-badge"><?= Uni::t('app', 'Accepted') ?></span>
                                                </td>
                                                <td class="uk-text-center"><a href="<?= Url::to("vaksinatsiya/vaksina/viloyat/$item->id") ?>"
                                                            data-id="<?= $item->id ?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <h3 class="uk-text-center"><a href="<?= Url::to('vaksinatsiya/default/all') ?>"><?= Uni::t('app', 'View all') ?></a>
                                    </h3>
                                </div>
                            </div>
                        </li>
                        <?php if (!empty(Prixod::getNew())): ?>
                            <div class="md-card-content">
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-table-nowrap uk-table-hover table_check">
                                        <thead>
                                        <tr>
                                            <th class="uk-width-2-10"><?= Uni::t('app', 'Arrival name') ?></th>
                                            <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Arrival number') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Arrival date') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (Prixod::getNew() as $item): ?>
                                            <tr>
                                                <td><?= (Uni::$app->language == 'ru') ? $item->name_ru : $item->name_uz; ?></td>
                                                <td class="uk-text-center"><?= $item->number ?></td>
                                                <td class="uk-text-center"><?= date('d-m-Y', $item->prixod_date) ?></td>
                                                <td class="uk-text-center"><span
                                                            class="uk-badge uk-badge-primary"><?= Uni::t('app', 'Accepted') ?></span>
                                                </td>
                                                <td class="uk-text-center"><a href="<?= Url::to("vaksinatsiya/default/view/$item->id") ?>"
                                                            data-id="<?= $item->id ?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <li aria-hidden="true" class=""><?= Uni::t('app', 'Received') ?></li>
                        <?php endif; ?>
                        <?php if (!empty(Prixod::getDenied())): ?>
                            <div class="md-card-content">
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-table-nowrap uk-table-hover table_check">
                                        <thead>
                                        <tr>
                                            <th class="uk-width-2-10"><?= Uni::t('app', 'Arrival name') ?></th>
                                            <th class="uk-width-2-10 uk-text-center"><?= Uni::t('app', 'Arrival number') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Arrival date') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Status') ?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?= Uni::t('app', 'Actions') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (Prixod::getDenied() as $item): ?>
                                            <tr>
                                                <td><?= (Uni::$app->language == 'ru') ? $item->name_ru : $item->name_uz; ?></td>
                                                <td class="uk-text-center"><?= $item->number ?></td>
                                                <td class="uk-text-center"><?= date('d-m-Y', $item->prixod_date) ?></td>
                                                <td class="uk-text-center"><span
                                                            class="uk-badge uk-badge-danger"><?= Uni::t('app', 'Accepted') ?></span>
                                                </td>
                                                <td class="uk-text-center"><a href="<?= Url::to("vaksinatsiya/default/view/$item->id") ?>"
                                                            data-id="<?= $item->id ?>">
                                                        <i class="md-icon material-icons uk-text-primary eye">&#xE417;</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <li aria-hidden="true" class=""><?= Uni::t('app', 'Cancelled') ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<h3 class="uk-text-left-medium" style="color:#4467E8"><?= Uni::t('app', 'Today') ?></h3>
<?Pjax::begin(['id'=>'filterData'])?>
    <div class="md-card">
        <div class="md-card-content">

            <?Form::begin(['id'=>'filterForm','method'=>'get','action'=>Url::getMain(),'options' => ['class' => '', 'data-pjax' => true]])?>
                    <div class="uk-grid" data-uk-grid-margin="">
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
                            <label for="product_search_name"><?= Uni::t('app', "Arrival name") ?></label>
                            <input name="name" type="text" class="md-input" id="product_search_name">
                        </div>
                        <div class="uk-width-medium-1-10">
                            <label for="product_search_name"><?= Uni::t('app', "Vaccine unit") ?></label>
                            <input name="name" type="text" class="md-input" id="product_search_name">
                        </div>
                        <div class="uk-width-medium-2-10">
                            <div class="uk-margin-small-top">
                                <select name="hayvon_turi" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?= Uni::t('app', "Animal type") ?></option>
                                    <? foreach (\app\models\HayvonTuri::find()->where(['status'=>1])->all() as $v) { ?>

                                        <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-10">
                            <div class="uk-margin-small-top">
                                <select name="hayvon_rangi" data-md-selectize data-md-selectize-bottom>
                                    <option value=""><?= Uni::t('app', "Animal color") ?></option>
                                    <? foreach (\app\models\HayvonRangi::find()->where(['status'=>1])->all() as $v) { ?>

                                        <option value="<?= $v->id ?>"><?= $v->name ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-10 uk-text-center">
                            <button type="submit" class="md-btn md-btn-primary uk-margin-small-top"><?= Uni::t('app', "Filter") ?></button>
                        </div>

                    </div>
                <?php Form::end() ?>
            </div>
    </div>
        <? Pjax::end()?>


<div class="md-card">
    <div class="md-card-content">
                <div class="uk-overflow-container">
                    <?Pjax::begin(['id'=>'listData'])?>
                    <table class="uk-table uk-table-nowrap uk-table-hover table_check">
                        <thead>
                        <tr>
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
                        <?php foreach ($per->models as $item): ?>
                            <tr>
                                <td><?= $item->manzil ?></td>
                                <td><?= $item->vaksina->name ?></td>
                                <td class="uk-text-center"><?= $item->vaksina_miqdor ?></td>
                                <td class="uk-text-center"><?= $item->hayvonTuri->name ?></td>
                                <td class="uk-text-center"><?= $item->hayvonRangi->name ?></td>
                                <td class="uk-text-center"><?= $item->hayvon_egasi ?>
                                </td>
                                <td class="uk-text-center"><?= date('d-m-Y', $item->created_at) ?></td>
                                <td class="uk-text-center"><a href="<?= Url::to("vaksinatsiya/vaksina/perform/$item->id") ?>"
                                            data-id="<?= $item->id ?>"><i class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= uni\widgets\LinkPager::widget([
                        'pagination' => $per->pagination,
                        'options'=>['class' => 'uk-pagination']
                    ]) ?>
                    <? Pjax::end()?>
                    <h3 class="uk-text-center"><a href="<?= Url::to('vaksinatsiya/vaksina/all') ?>"><?= Uni::t('app', 'View all') ?></a>
                    </h3>
                </div>
            </div>
        </div>

