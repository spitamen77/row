<?php
/**
 * Created by Sublime.
 * Author: Sarvar Makhmudjanov
 * Web: http://code.uz
 * Date: 11.12.2018 21:14
 * Content: "Unibox"
 * Site: http://simplex.uz
 */


use app\models\Lang;
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\helpers\ArrayHelper;

$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$current = Lang::getCurrent();
// if ($current->url=="ru") $map = ArrayHelper::map($items,'id','name_ru');
// else $map = ArrayHelper::map($items,'id','name_uz');
$this->title = Uni::t('app', 'Viloyat dashboard');
?>
<h4 class="heading_a uk-margin-bottom">Viloyat boshqaruv panel</h4>
<div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler" data-uk-sortable="" data-uk-grid-margin="">
    <div class="uk-row-first" style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data" style="display: none;">5,3,9,6,5,9,7</span><svg class="peity" height="28" width="48"><rect fill="#d84315" x="1.3714285714285717" y="12.444444444444443" width="4.114285714285715" height="15.555555555555557"></rect><rect fill="#d84315" x="8.228571428571428" y="18.666666666666668" width="4.114285714285716" height="9.333333333333332"></rect><rect fill="#d84315" x="15.085714285714287" y="0" width="4.1142857142857086" height="28"></rect><rect fill="#d84315" x="21.942857142857147" y="9.333333333333336" width="4.114285714285707" height="18.666666666666664"></rect><rect fill="#d84315" x="28.800000000000004" y="12.444444444444443" width="4.114285714285707" height="15.555555555555557"></rect><rect fill="#d84315" x="35.65714285714286" y="0" width="4.114285714285707" height="28"></rect><rect fill="#d84315" x="42.51428571428572" y="6.222222222222221" width="4.114285714285707" height="21.77777777777778"></rect></svg></div>
                <span class="uk-text-muted uk-text-small">Prixod vaksinalar</span>
                <h2 class="uk-margin-remove"><span class="countUpMe">12,456</span></h2>
            </div>
        </div>
    </div>
    <div style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data" style="display: none;">5,3,9,6,5,9,7,3,5,2</span><svg class="peity" height="28" width="64"><polygon fill="#d1e4f6" points="0 27.5 0 12.5 7.111111111111111 18.5 14.222222222222221 0.5 21.333333333333332 9.5 28.444444444444443 12.5 35.55555555555556 0.5 42.666666666666664 6.5 49.77777777777777 18.5 56.888888888888886 12.5 64 21.5 64 27.5"></polygon><polyline fill="none" points="0 12.5 7.111111111111111 18.5 14.222222222222221 0.5 21.333333333333332 9.5 28.444444444444443 12.5 35.55555555555556 0.5 42.666666666666664 6.5 49.77777777777777 18.5 56.888888888888886 12.5 64 21.5" stroke="#0288d1" stroke-width="1" stroke-linecap="square"></polyline></svg></div>
                <span class="uk-text-muted uk-text-small">Sale</span>
                <h2 class="uk-margin-remove">$<span class="countUpMe">Qabul qilingalar</span></h2>
            </div>
        </div>
    </div>
    <div style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data" style="display: none;">64/100</span><svg class="peity" height="24" width="24"><path d="M 12 0 A 12 12 0 1 1 2.753841086690528 19.649087876984275 L 7.376920543345264 15.824543938492138 A 6 6 0 1 0 12 6" fill="#8bc34a"></path><path d="M 2.753841086690528 19.649087876984275 A 12 12 0 0 1 11.999999999999998 0 L 11.999999999999998 6 A 6 6 0 0 0 7.376920543345264 15.824543938492138" fill="#eee"></path></svg></div>
                <span class="uk-text-muted uk-text-small">Bekor qilinganlar</span>
                <h2 class="uk-margin-remove"><span class="countUpMe">64</span>%</h2>
            </div>
        </div>
    </div>
    <div style="">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data" style="display: none;">64/100</span><svg class="peity" height="24" width="24"><path d="M 12 0 A 12 12 0 1 1 2.753841086690528 19.649087876984275 L 7.376920543345264 15.824543938492138 A 6 6 0 1 0 12 6" fill="#8bc34a"></path><path d="M 2.753841086690528 19.649087876984275 A 12 12 0 0 1 11.999999999999998 0 L 11.999999999999998 6 A 6 6 0 0 0 7.376920543345264 15.824543938492138" fill="#eee"></path></svg></div>
                <span class="uk-text-muted uk-text-small">Qabul qilimaganlar</span>
                <h2 class="uk-margin-remove"><span class="countUpMe">64</span>%</h2>
            </div>
        </div>
    </div>
</div>




<div class="uk-grid uk-margin-medium-bottom" data-uk-grid-margin="">
    <div class="uk-width-medium-1-2 uk-row-first">
        <h4 class="heading_a uk-margin-bottom">Kirim va chiqimlar</h4>
        <div class="md-card">
            <div class="md-card-content">
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-width-1-3 uk-active" aria-expanded="true"><a href="#">Yangi prixodlar</a></li>
                    <li class="uk-width-1-3" aria-expanded="false"><a href="#">Qabul qilinganlar</a></li>
                    <li class="uk-width-1-3" aria-expanded="false"><a href="#">Bekor qilinganlar</a></li>
                <li class="uk-tab-responsive uk-active uk-hidden" aria-haspopup="true" aria-expanded="false"><a>Active</a><div class="uk-dropdown uk-dropdown-small" aria-hidden="true"><ul class="uk-nav uk-nav-dropdown"></ul><div></div></div></li></ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li aria-hidden="false" class="uk-active">
                        <div class="md-card-content">
                            <div class="uk-overflow-container">
                                <table class="uk-table uk-table-nowrap table_check">
                                    <thead>
                                    <tr>
                                        <th class="uk-width-1-10 uk-text-center small_col"><input type="checkbox" data-md-icheck class="check_all"></th>
                                        <th class="uk-width-2-10">User Name</th>
                                        <th class="uk-width-2-10 uk-text-center">Order Number</th>
                                        <th class="uk-width-1-10 uk-text-center">Order Date</th>
                                        <th class="uk-width-1-10 uk-text-center">Status</th>
                                        <!-- <th class="uk-width-2-10 uk-text-center">Actions</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row"></td>
                                            <td>Bradley Ullrich</td>
                                            <td class="uk-text-center">42/2015</td>
                                            <td class="uk-text-center">25-06-1975</td>
                                            <td class="uk-text-center"><span class="uk-badge">Accepted</span></td>
                                            
                                        </tr>
                                        <tr>
                                            <td class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row"></td>
                                            <td>Ramon O'Hara</td>
                                            <td class="uk-text-center">27/2015</td>
                                            <td class="uk-text-center">01-12-1996</td>
                                            <td class="uk-text-center"><span class="uk-badge uk-badge-success">Shipped</span></td>
                                           
                                        </tr>
                                        <tr>
                                            <td class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row"></td>
                                            <td>Ellsworth Nader</td>
                                            <td class="uk-text-center">94/2015</td>
                                            <td class="uk-text-center">07-01-1972</td>
                                            <td class="uk-text-center"><span class="uk-badge uk-badge-danger">Declined</span></td>
                                            
                                        </tr>
                                        <tr>
                                            <td class="uk-text-center uk-table-middle small_col"><input type="checkbox" data-md-icheck class="check_row"></td>
                                            <td>Tad Ward</td>
                                            <td class="uk-text-center">31/2015</td>
                                            <td class="uk-text-center">27-08-1979</td>
                                            <td class="uk-text-center"><span class="uk-badge uk-badge-primary">New</span></td>
                                            <!-- <td class="uk-text-center">
                                                <a href="#"><i class="md-icon material-icons">&#xE254;</i></a>
                                                <a href="#"><i class="md-icon material-icons">&#xE88F;</i></a>
                                            </td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <ul class="uk-pagination uk-margin-medium-top">
                                <li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>
                                <li class="uk-active"><span>1</span></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><span>&hellip;</span></li>
                                <li><a href="#">10</a></li>
                                <li><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>
                            </ul> -->
                        </div>
                    </li>
                    <li aria-hidden="true" class="">Qabul qilinganlar</li>
                    <li aria-hidden="true" class="">Bekor qilinganlar</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <h4 class="heading_a uk-margin-bottom">Kirim va chiqimlar</h4>
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading_c uk-margin-bottom">Prixod va rasxodlar</h4>
                <div id="c3_chart_area_stacked" class="c3chart"></div>
            </div>
        </div>
    </div>
</div>


<h4 class="heading_a uk-margin-bottom uk-margin-large-top">Tizim malumotlari</h4>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-3">
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading_c uk-margin-bottom">Vaksinalar bo'yicha hisobot</h4>
                <div id="c3_chart_donut" class="c3chart"></div>
            </div>
        </div>
    </div>
    <div class="uk-width-medium-2-3">
        <div class="md-card">
            <div class="md-card-content">
                <h4 class="heading_c uk-margin-bottom">Foydalanuvchilar</h4>
                <div id="c3_chart_bar_stacked" class="c3chart"></div>
            </div>
        </div>
    </div>
</div>
