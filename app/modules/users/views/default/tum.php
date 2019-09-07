<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 26.12.2018 17:36
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

use app\assets\CoreAssets;
use app\models\Lang;
use app\models\Prixod;
use uni\helpers\Url;

$q = false;
if (isset($_GET['q'])) {
    $q = $_GET['q'];
}
$current = Lang::getCurrent();
// if ($current->url=="ru") $map = ArrayHelper::map($items,'id','name_ru');
// else $map = ArrayHelper::map($items,'id','name_uz');
$this->title = Uni::t('app', 'Main page');

$this->registerJsFile('/../../themes/ui/components/d3/d3.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/components/c3js-chart/c3.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/components/chartist/dist/chartist.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerCssFile('/../../themes/ui/components/chartist/dist/chartist.min.css', ['depends' => [CoreAssets::className()]]);
//$this->registerJsFile('/../../themes/ui/assets/js/pages/plugins_charts.min.js', ['depends' => [CoreAssets::className()]]);

?>
    <h4 class="heading_a uk-margin-bottom"><?= Uni::t('app', 'Administration panel') ?> - <?php
        if(Uni::$app->controller->access('ADMIN_TUM')){
            $tuman_user = Uni::$app->getUser()->identity->personal->tuman_id;
            $tuman =  \app\models\Tuman::findOne($tuman_user);
            echo $tuman->viloyat->name.', '.$tuman->name;
        }
        elseif(Uni::$app->controller->access('ADMIN_VIL')){
            $viloyat_user = Uni::$app->getUser()->identity->personal->viloyat_id;
            $viloyat = \app\models\Viloyat::findOne($viloyat_user);
            echo $viloyat->name;
        }
        elseif (Uni::$app->controller->access('ADMIN')||Uni::$app->controller->access('HEAD')){
            echo Uni::$app->user->identity->makeFIO();
        }

        ?></h4>
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
                    <h2 class="uk-margin-remove"><span class="countUpMe"><?=Prixod::getCount()?></span></h2>
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
                    <h2 class="uk-margin-remove"><span class="countUpMe"><?=(Prixod::getRasxod()==0)? 0: Prixod::getRasxod()?></span></h2>
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
                    <h2 class="uk-margin-remove"><span class="countUpMe"><?=(Prixod::getKutish()==0)? 0: Prixod::getKutish()?></span></h2>
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
                    <h2 class="uk-margin-remove"><span class="countUpMe"><?=(Prixod::getOtkaz()==0)? 0: Prixod::getOtkaz()?></span></h2>
                </div>
            </div>
        </div>
    </div>


    <div class="uk-grid uk-margin-medium-bottom" data-uk-grid-margin="">
        <div class="uk-width-medium-1-2 uk-row-first">
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
                                    <table class="uk-table uk-table-nowrap table_check">
                                        <thead>
                                        <tr>
                                            <th class="uk-width-2-10"><?=Uni::t('app', 'Arrival name')?></th>
                                            <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app', 'Arrival number')?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Arrival date')?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Status')?></th>
                                            <!-- <th class="uk-width-2-10 uk-text-center">Actions</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (Prixod::getAccepted() as $item): ?>
                                            <tr>
                                                <td><?=($item->prixod)? $item->prixod->name: Uni::t('app', 'Not set') ?></td>
                                                <td class="uk-text-center"><?=$item->nomer?></td>
                                                <td class="uk-text-center"><?=date('d-m-Y', $item->prixod_date)?></td>
                                                <td class="uk-text-center"><span class="uk-badge"><?=Uni::t('app', 'Accepted')?></span></td>

                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <?php if (!empty(Prixod::getNew())): ?>
                            <div class="md-card-content">
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-table-nowrap table_check">
                                        <thead>
                                        <tr>
                                            <th class="uk-width-2-10"><?=Uni::t('app', 'Arrival name')?></th>
                                            <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app', 'Arrival number')?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Arrival date')?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Status')?></th>
                                            <!-- <th class="uk-width-2-10 uk-text-center">Actions</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (Prixod::getNew() as $item): ?>
                                            <tr>

                                                <td><?=($item->prixod)? $item->prixod->name: Uni::t('app', 'Not set') ?></td>
                                                <td class="uk-text-center"><?=$item->nomer?></td>
                                                <td class="uk-text-center"><?=date('d-m-Y', $item->prixod_date)?></td>
                                                <td class="uk-text-center"><span class="uk-badge uk-badge-primary"><?=Uni::t('app', 'Accepted')?></span></td>

                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <li aria-hidden="true" class=""><?=Uni::t('app', 'Received')?></li>
                        <?php endif; ?>
                        <?php if (!empty(Prixod::getDenied())): ?>
                            <div class="md-card-content">
                                <div class="uk-overflow-container">
                                    <table class="uk-table uk-table-nowrap table_check">
                                        <thead>
                                        <tr>
                                            <th class="uk-width-2-10"><?=Uni::t('app', 'Arrival name')?></th>
                                            <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app', 'Arrival number')?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Arrival date')?></th>
                                            <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app', 'Status')?></th>
                                            <!-- <th class="uk-width-2-10 uk-text-center">Actions</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (Prixod::getDenied() as $item): ?>
                                            <tr>
                                                <td><?=($item->prixod)? $item->prixod->name: Uni::t('app', 'Not set') ?></td>
                                                <td class="uk-text-center"><?=$item->nomer?></td>
                                                <td class="uk-text-center"><?=date('d-m-Y', $item->prixod_date)?></td>
                                                <td class="uk-text-center"><span class="uk-badge uk-badge-danger"><?=Uni::t('app', 'Accepted')?></span></td>

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
                    <a href="<?=Url::to('settings/arrival/index')?>" class="md-btn md-btn-wave waves-effect waves-button"><?=Uni::t('app','View all')?></a>

                </div>
            </div>
        </div>
        <div class="uk-width-large-1-2">
            <h4 class="heading_a uk-margin-bottom"><?=Uni::t('app', 'Income and expenses')?></h4>
            <div class="md-card">
                <div class="md-card-content">
                    <h4 class="heading_c uk-margin-bottom"><?=Uni::t('app', 'Income and expenses')?></h4>
                    <div style="height: 350px" id="chartist_line_area" class="chartist"></div>
                </div>
            </div>
        </div>
        <!-- <div class="uk-width-medium-1-2">
        <h4 class="heading_a uk-margin-bottom"><?#=Uni::t('app', 'Income and expenses')?></h4>
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading_c uk-margin-bottom"><?#=Uni::t('app', 'income and expenditure')?></h4>
                <div id="c3_chart_area_stacked" class="c3chart"></div>
            </div>
        </div>
    </div> -->
    </div>



    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3">
            <h4 class="heading_a uk-margin-bottom uk-margin-large-top"><?=Uni::t('app', 'Information by incomings')?></h4>
            <div class="md-card">
                <div class="md-card-content">
                    <h4 class="heading_c uk-margin-bottom"><?=Uni::t('app', 'Vaccine Report')?></h4>
                    <div id="c3_chart_donut" class="c3chart"></div>
                </div>
            </div>
        </div>
        <div class="uk-width-large-1-3">
            <h4 class="heading_a uk-margin-bottom uk-margin-large-top"><?=Uni::t('app', 'Information by Diseases')?></h4>
            <div class="md-card">
                <div class="md-card-content">
                    <h4 class="heading_c uk-margin-bottom"><?=Uni::t('app', 'Most sepereted 3 diseases')?></h4>
                    <div id="chartist_pie_custom_labels" class="chartist"></div>
                </div>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <h4 class="heading_a uk-margin-bottom uk-margin-large-top"><?=Uni::t('app', 'Information by users')?></h4>
            <div class="md-card">
                <div class="md-card-content">
                    <h4 class="heading_c uk-margin-bottom">Distributed Series</h4>
                    <div id="chartist_distributed_series" class="chartist"></div>
                </div>
            </div>
        </div>
    </div>
<?
$vkvk = "";
//foreach ($vk as $v) {
//    $vkvk = $vkvk."['".$v['name']."',".$v['count']."],";
//}
//print_r($vkvk);
$this->registerJs("
    
    var c3chart_area_stacked_id = '#c3_chart_area_stacked';

        if ( $(c3chart_area_stacked_id).length ) {

            var c3chart_area_stacked = c3.generate({
                bindto: c3chart_area_stacked_id,
                data: {
                    columns: [
                        ['data1', 300, 350, 300, 0, 0, 120],
                        ['data2', 130, 100, 140, 200, 150, 50]
                    ],
                    types: {
                        data1: 'area-spline',
                        data2: 'area-spline'
                    },
                    groups: [['data1', 'data2']]
                },
                color: {
                    pattern: ['#1565C0', '#727272']
                }
            });

            $(window).on('debouncedresize', function () {
                c3chart_area_stacked.resize();
            });

        }
        // donut chart
        var c3chart_donut_id = '#c3_chart_donut';

        if ( $(c3chart_donut_id).length ) {

            var c3chart_donut = c3.generate({
                bindto: c3chart_donut_id,
                data: {
                    columns: [
                        ['data1', 30],
                        ['data2', 120]
                    ],
                    type : 'donut',
                    onclick: function (d, i) { console.log('onclick', d, i); },
                    onmouseover: function (d, i) { console.log('onmouseover', d, i); },
                    onmouseout: function (d, i) { console.log('onmouseout', d, i); }
                },
                donut: {
                    //title: '".Uni::t('app','Most 3 regions')."',
                    width: 50
                },
                color: {
                    pattern: ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf']
                }
            });

            $(c3chart_donut_id).waypoint({
                handler: function() {
                    setTimeout(function () {
                        c3chart_donut.load({
                            columns: [
                                
                                    [12, 9, 7, 8, 5],
                                    [2, 1, 3.5, 7, 3],
                                    [1, 3, 4, 5, 6]
                               
                            ]
                        });
                    }, 1500);

                    setTimeout(function () {
                        c3chart_donut.unload({
                            ids: 'data1'
                        });
                        c3chart_donut.unload({
                            ids: 'data2'
                        });
                        c3chart_donut.unload({
                            ids: 'data3'
                        });
                    }, 2500);
                    this.destroy();
                },
                offset: '80%'
            });

            $(window).on('debouncedresize', function () {
                c3chart_donut.resize();
            });


        }
        var ch_line_area = new Chartist.Line('#chartist_line_area', {
        labels: ['Dekabr', 'Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun'],
        series: [
            [50, 150, 48, 120, 110, 90, 170, 155]
        ]
        }, {
            low: 0,
            showArea: true
        });
        $(window).on('resize',function() {
            //ch_line_area.update();
        });
        
        // pie chart with custom labels
        var data = {
            labels: ['".Uni::t('app','Disease name 1')."', '".Uni::t('app','Disease name 1')."', '".Uni::t('app','Disease name 1')."'],
            series: [20, 15, 40]
        };

        var options = {
            labelInterpolationFnc: function(value) {
                return value[0]
            }
        };

        var responsiveOptions = [
            ['screen and (max-width: 767px)', {
                chartPadding: 50,
                labelOffset: 50,
                labelDirection: 'explode',
                labelInterpolationFnc: function(value) {
                    return value;
                }
            }],
            ['screen and (min-width: 768px)', {
                chartPadding: 30,
                labelOffset: 60,
                labelDirection: 'explode',
                labelInterpolationFnc: function(value) {
                    return value;
                }
            }],
            ['screen and (min-width: 1024px)', {
                labelOffset: 80,
                chartPadding: 20
            }]
        ];

        var ch_pie_custom_labels = new Chartist.Pie('#chartist_pie_custom_labels', data, options, responsiveOptions);
        $(window).on('resize',function() {
            ch_pie_custom_labels.update();
        });

        // distributed series
        var ch_distributed_series = new Chartist.Bar('#chartist_distributed_series', {
            labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
            series: [20, 60, 120, 200, 180, 20, 10]
        }, {
            distributeSeries: true
        });
        $(window).on('resize',function() {
            ch_distributed_series.update();
        });
    ");
?>