<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
$this->title = Uni::t('app','Reports');
\app\components\widgets\SweetAlertAsset::register($this);

?>
<h3><?=$this->title?></h3>
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-4 uk-grid-width-large-1-4 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <a href="#<?//=Url::to('')?>">
                <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                    <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
                </div>
            </a>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t("app","Daily report")?>
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t("app","Monthly report")?>
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t("app","Quarterly report")?>
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
   <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t("app","Yearly report")?>
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
</div>

<h3><?=Uni::t("app","Report by type")?></h3>
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-4 uk-grid-width-large-1-4 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <a href="#<?//=Url::to('')?>">
                <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                    <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
                </div>
            </a>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>1000
                        "<?=Uni::t("app","Owner reports")?>"
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>2000
                        "<?=Uni::t("app","Vaccine Report")?>"
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>3000
                        "<?=Uni::t("app","Vaksinatsiya report")?>"
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card md-card-hover md-card-overlay">
            <div class="md-card-content uk-flex uk-flex-center uk-flex-middle">
                <img src="/themes/images/dailyreport.jpg" style="padding: 60px">
            </div>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>4000
                        "<?=Uni::t("app","Diagnose report")?>"
                    </h3>
                </div>
                <button class="md-btn md-btn-primary" ><?=Uni::t("app","Download excel")?></button>
            </div>
        </div>
    </div>
</div>