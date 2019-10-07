<? use app\components\manager\Url;?>




<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable data-uk-grid-margin>
    <div>

            <div class="md-card md-card-hover md-card-overlay">
                <a href="<?=Url::to("cpanel/users/index")?>">
                <div class="md-card-content">
                    <div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
                        <span class="epc_chart_icon"> <i class="material-icons">&#xE7FB;</i></span>
                    </div>
                </div>
                    </a>
                <div class="md-card-overlay-content">
                    <div class="uk-clearfix md-card-overlay-header">
                        <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>

                        <h3>
                            <?=Uni::t('app','Users')?>
                        </h3>
                    </div>
                    <?=Uni::t('app','There you can manage users')?>
                </div>
            </div>

    </div>
    <div>

        <div class="md-card md-card-hover md-card-overlay">
            <a href="<?=Url::to("cpanel/default/groups")?>">
                <div class="md-card-content">
                    <div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
                        <span class="epc_chart_icon"><i class="material-icons">&#xE886;</i></span>
                    </div>
                </div>
            </a>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t('app','Groups')?>
                    </h3>
                </div>
                <?=Uni::t('app','There you can manage groups')?>
            </div>
        </div>

    </div>
    <div>

        <div class="md-card md-card-hover md-card-overlay">
            <a href="<?=Url::to("cpanel/default/modules")?>">
                <div class="md-card-content">
                    <div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
                        <span class="epc_chart_icon"><i class="material-icons">&#xE8F0;</i></span>
                    </div>
                </div>
            </a>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t('app','Modules')?>
                    </h3>
                </div>
                <?=Uni::t('app','There you can manage modules')?>
            </div>
        </div>

    </div>
    <div>

        <div class="md-card md-card-hover md-card-overlay">
            <a href="<?=Url::to("reference/default/index")?>">
                <div class="md-card-content">
                    <div class="epc_chart" data-percent="76" data-bar-color="#03a9f4">
                        <span class="epc_chart_icon"><i class="material-icons">&#xE8B8;</i></span>
                    </div>
                </div>
            </a>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                    <h3>
                        <?=Uni::t('app','Configuration')?>
                    </h3>
                </div>
                <?=Uni::t('app','There you can manage configuration of system')?>
            </div>
        </div>

    </div>
</div>