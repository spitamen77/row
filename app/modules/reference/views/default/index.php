<?php
$this->title = Uni::t('app', 'Reference settings');
?>
<h3><?=$this->title?></h3>
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('cpanel/users/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app', 'Users')?>
                    </h2>
                    <p><?=Uni::t('app', 'This section you can manage users of system')?> &hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('cpanel/users/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>

    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('cpanel/default/groups')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app', 'User groups')?>
                    </h2>
                    <p><?=Uni::t('app', 'This section you can manage types of user groups')?> &hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('cpanel/default/groups')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>

    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('reference/default/translation')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app', 'Translation')?>
                    </h2>
                    <p><?=Uni::t('app', 'This section you can manage translation of system')?> &hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('reference/default/translation')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
</div>
<hr>
<!--Viloyatlar-->
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('reference/viloyat/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Region')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('reference/viloyat/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('reference/tuman/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','City')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('reference/tuman/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('reference/hudud/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Hudud')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('reference/hudud/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
</div>
<hr>
<!-- Vaksinalar-->
<h3><?=Uni::t('app', 'Vaccine settings')?></h3>
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">

    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/vkturi/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Vaccine type')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/vkturi/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/vaksina/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Vaccine')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/vaksina/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div><div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/unit/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Unit type')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/unit/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
<!--    <div>-->
<!--        <div class="md-card md-card-hover-img">-->
<!--            <a href="--><?//=$this->to('settings/turi/index')?><!--">-->
<!--                <div class="md-card-content">-->
<!--                    <h2 class="heading_a uk-margin-bottom">-->
<!--                        --><?//=Uni::t('app','Drug')?>
<!--                    </h2>-->
<!--                    <p>This section you can change settings of system&hellip;</p>-->
<!--                    <a class="md-btn md-btn-small" href="--><?//=$this->to('settings/turi/index')?><!--">--><?//=Uni::t('app', 'More')?><!--</a>-->
<!--                </div>-->
<!--            </a>-->
<!---->
<!--        </div>-->
<!--    </div>-->
</div>
<hr>
<!-- Hayvonlar-->
<h3><?=Uni::t('app', 'Disease and animal')?></h3>
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/hyturi/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Animal type')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/hyturi/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/hayvon/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Animal')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/hayvon/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
</div>
<hr>
<!-- Kasalliklar-->
<div class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-3 hierarchical_show" data-uk-grid="{gutter: 20, controls: '#products_sort'}">
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/kasturi/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Disease type')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/kasturi/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
    <div>
        <div class="md-card md-card-hover-img">
            <a href="<?=$this->to('settings/kasallik/index')?>">
                <div class="md-card-content">
                    <h2 class="heading_a uk-margin-bottom">
                        <?=Uni::t('app','Disease')?>
                    </h2>
                    <p>This section you can change settings of system&hellip;</p>
                    <a class="md-btn md-btn-small" href="<?=$this->to('settings/kasallik/index')?>"><?=Uni::t('app', 'More')?></a>
                </div>
            </a>

        </div>
    </div>
</div>
