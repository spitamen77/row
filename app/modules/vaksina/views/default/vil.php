<?php
/**
 * Created by PhpStorm.
 * User: rashidovn
 * Date: 12/17/18
 * Time: 11:40
 */

use app\assets\CoreAssets;
use app\models\Lang;
use app\models\Prixod;
use app\components\manager\Url;

$q = false;
if (isset($_GET['q'])) {
    $q = $_GET['q'];
}
$current = Lang::getCurrent();
$this->title = Uni::t('app', 'Vaccine');

$this->registerJsFile('/../../themes/ui/components/d3/d3.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/components/c3js-chart/c3.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/assets/js/pages/plugins_charts.min.js', ['depends' => [CoreAssets::className()]]);

?>
<h4 class="heading_a uk-margin-bottom"><?= Uni::t('app', 'Administration panel') ?></h4>
<div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler"
     data-uk-sortable="" data-uk-grid-margin="">
    <div class="uk-row-first" style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"
                                                                                      style="display: none;">64/100</span>
                    <svg class="peity" height="24" width="24">
                        <path d="M 12 0 A 12 12 0 1 1 2.753841086690528 19.649087876984275 L 7.376920543345264 15.824543938492138 A 6 6 0 1 0 12 6"
                              data-value="64" fill="#8bc34a"></path>
                        <path d="M 2.753841086690528 19.649087876984275 A 12 12 0 0 1 11.999999999999998 0 L 11.999999999999998 6 A 6 6 0 0 0 7.376920543345264 15.824543938492138"
                              data-value="36" fill="#eee"></path>
                    </svg>
                </div>
                <span class="uk-text-muted uk-text-small"><?=Uni::t('app', 'Income vaccines')?></span>
                <h2 class="uk-margin-remove"><span class="countUpMe"><?=Prixod::getCount($viloyat_id)?></span></h2>
            </div>
        </div>
    </div>
    <div style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"
                                                                                      style="display: none;">64/100</span>
                    <svg class="peity" height="24" width="24">
                        <path d="M 12 0 A 12 12 0 1 1 2.753841086690528 19.649087876984275 L 7.376920543345264 15.824543938492138 A 6 6 0 1 0 12 6"
                              data-value="64" fill="#8bc34a"></path>
                        <path d="M 2.753841086690528 19.649087876984275 A 12 12 0 0 1 11.999999999999998 0 L 11.999999999999998 6 A 6 6 0 0 0 7.376920543345264 15.824543938492138"
                              data-value="36" fill="#eee"></path>
                    </svg>
                </div>
                <span class="uk-text-muted uk-text-small"><?=Uni::t('app', 'Received')?></span>
                <h2 class="uk-margin-remove"><span class="countUpMe"><?=(Prixod::getRasxod($viloyat_id)==0)? 0: Prixod::getRasxod($viloyat_id)?></span></h2>
            </div>
        </div>
    </div>
    <div style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"
                                                                                      style="display: none;">64/100</span>
                    <svg class="peity" height="24" width="24">
                        <path d="M 12 0 A 12 12 0 1 1 2.753841086690528 19.649087876984275 L 7.376920543345264 15.824543938492138 A 6 6 0 1 0 12 6"
                              data-value="64" fill="#8bc34a"></path>
                        <path d="M 2.753841086690528 19.649087876984275 A 12 12 0 0 1 11.999999999999998 0 L 11.999999999999998 6 A 6 6 0 0 0 7.376920543345264 15.824543938492138"
                              data-value="36" fill="#eee"></path>
                    </svg>
                </div>
                <span class="uk-text-muted uk-text-small"><?=Uni::t('app', 'Not accepted')?></span>
                <h2 class="uk-margin-remove"><span class="countUpMe"><?=(Prixod::getKutish($viloyat_id)==0)? 0: Prixod::getKutish($viloyat_id)?></span></h2>
            </div>
        </div>
    </div>
    <div style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"
                                                                                      style="display: none;">64/100</span>
                    <svg class="peity" height="24" width="24">
                        <path d="M 12 0 A 12 12 0 1 1 2.753841086690528 19.649087876984275 L 7.376920543345264 15.824543938492138 A 6 6 0 1 0 12 6"
                              fill="#8bc34a"></path>
                        <path d="M 2.753841086690528 19.649087876984275 A 12 12 0 0 1 11.999999999999998 0 L 11.999999999999998 6 A 6 6 0 0 0 7.376920543345264 15.824543938492138"
                              fill="#eee"></path>
                    </svg>
                </div>
                <span class="uk-text-muted uk-text-small"><?=Uni::t('app', 'Returned')?></span>
                <h2 class="uk-margin-remove"><span class="countUpMe"><?=(Prixod::getOtkaz($viloyat_id)==0)? 0: Prixod::getOtkaz($viloyat_id)?></span></h2>
            </div>
        </div>
    </div>
</div>


<div class="uk-grid uk-margin-medium-bottom" data-uk-grid-margin="">
    <div class="uk-width-medium-3-3 uk-row-first">
        <h4 class="heading_a uk-margin-bottom"><?=Uni::t('app', 'Income and expenses')?></h4>
        <div class="md-card">
            <div class="md-card-content">
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-width-1-3 uk-active" aria-expanded="true"><a href="#"><?=Uni::t('app', 'Received')?></a></li>
                    <li class="uk-width-1-3" aria-expanded="false"><a href="#"><?=Uni::t('app', 'New arrival')?></a></li>
                    <li class="uk-width-1-3" aria-expanded="false"><a href="#"><?=Uni::t('app', 'Canceled')?></a></li>
                    <li class="uk-tab-responsive uk-active uk-hidden" aria-haspopup="true" aria-expanded="false"><a><?=Uni::t('app', 'Active')?></a>
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
                                        <th class="uk-width-2-10"><?=Uni::t('app', 'Arrival name')?></th>
                                        <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app', 'Arrival number')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Arrival date')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Status')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Actions')?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (Prixod::getAccepted($viloyat_id) as $item): ?>
                                        <tr>
                                            <td><?=$item->viloyat->name; ?></td>
                                            <td class="uk-text-center"><?=$item->nomer?></td>
                                            <td class="uk-text-center"><?=date('d-m-Y', $item->proxod_date)?></td>
                                            <td class="uk-text-center"><span class="uk-badge"><?=Uni::t('app', 'Accepted')?></span></td>
                                            <td class="uk-text-center"><a href="<?=Url::to("vaksinatsiya/default/view/$item->proxod_id")?>" data-id="<?= $item->id ?>"><i
                                                        class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a></td>

                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <h3 class="uk-text-center"><a href="<?=Url::to('vaksinatsiya/default/all')?>"><?=Uni::t('app', 'View all')?></a> </h3>
                            </div>
                        </div>
                    </li>
                    <?php if (!empty(Prixod::getNew())): ?>
                        <div class="md-card-content">
                            <div class="uk-overflow-container">
                                <table class="uk-table uk-table-nowrap uk-table-hover table_check">
                                    <thead>
                                    <tr>
                                        <th class="uk-width-2-10"><?=Uni::t('app', 'Arrival name')?></th>
                                        <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app', 'Arrival number')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Arrival date')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Status')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Actions')?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (Prixod::getNew($viloyat_id) as $item): ?>
                                        <tr>
                                            <td><?=$item->viloyat->name; ?></td>
                                            <td class="uk-text-center"><?=$item->nomer?></td>
                                            <td class="uk-text-center"><?=date('d-m-Y', $item->proxod_date)?></td>
                                            <td class="uk-text-center"><span class="uk-badge uk-badge-primary"><?=Uni::t('app', 'Accepted')?></span></td>
                                            <td class="uk-text-center"><a href="<?=Url::to("vaksinatsiya/default/view/$item->id")?>" data-id="<?= $item->id ?>"><i
                                                        class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <li aria-hidden="true" class=""><?=Uni::t('app', 'Received')?></li>
                    <?php endif; ?>
                    <?php if (!empty(Prixod::getDenied($viloyat_id))): ?>
                        <div class="md-card-content">
                            <div class="uk-overflow-container">
                                <table class="uk-table uk-table-nowrap uk-table-hover table_check">
                                    <thead>
                                    <tr>
                                        <th class="uk-width-2-10"><?=Uni::t('app', 'Arrival name')?></th>
                                        <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app', 'Arrival number')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Arrival date')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Status')?></th>
                                        <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Actions')?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (Prixod::getDenied($viloyat_id) as $item): ?>
                                        <tr>
                                            <td><?=$item->viloyat->name; ?></td>
                                            <td class="uk-text-center"><?=$item->nomer?></td>
                                            <td class="uk-text-center"><?=date('d-m-Y', $item->proxod_date)?></td>
                                            <td class="uk-text-center"><span class="uk-badge uk-badge-danger"><?=Uni::t('app', 'Accepted')?></span></td>
                                            <td class="uk-text-center"><a href="<?=Url::to("vaksinatsiya/default/view/$item->id")?>" data-id="<?= $item->id ?>"><i
                                                        class="md-icon material-icons uk-text-primary eye">&#xE417;</i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <li aria-hidden="true" class=""><?=Uni::t('app', 'Cancelled')?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!--    <div class="uk-width-medium-1-2">-->
    <!--        <h4 class="heading_a uk-margin-bottom">--><?//=Uni::t('app', 'Income and expenses')?><!--</h4>-->
    <!--        <div class="md-card">-->
    <!--            <div class="md-card-content">-->
    <!--                <h4 class="heading_c uk-margin-bottom">--><?//=Uni::t('app', 'income and expenditure')?><!--</h4>-->
    <!--                <div id="c3_chart_area_stacked" class="c3chart"></div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</div>


<!--<div class="uk-grid" data-uk-grid-margin>-->
<!--    <div class="uk-width-medium-2-3">-->
<!--        <h4 class="heading_a uk-margin-bottom">--><?//=Uni::t('app', 'Income and expenses')?><!--</h4>-->
<!--        <div class="md-card">-->
<!--            <div class="md-card-content">-->
<!--                <h4 class="heading_c uk-margin-bottom">--><?//=Uni::t('app', 'income and expenditure')?><!--</h4>-->
<!--                <div id="c3_chart_area_stacked" class="c3chart"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
