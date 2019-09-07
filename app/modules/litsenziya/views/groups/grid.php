<? if ($companies) { ?>
    <div id="contact_list_v2-nav" class="listNav">
        <div class="ln-letters">
            <a class="all ln-selected" href="#">All</a>
            <a class="_ ln-disabled" href="#">0-9</a>
            <a class="a" href="#">A</a><a class="b ln-disabled" href="#">B</a>
            <a class="c" href="#">C</a>
            <a class="d" href="#">D</a>
            <a class="e ln-disabled" href="#">E</a>
            <a class="f ln-disabled" href="#">F</a>
            <a class="g" href="#">G</a>
            <a class="h" href="#">H</a>
            <a class="i ln-disabled" href="#">I</a>
            <a class="j ln-disabled" href="#">J</a>
            <a class="k" href="#">K</a>
            <a class="l" href="#">L</a>
            <a class="m" href="#">M</a>
            <a class="n ln-disabled" href="#">N</a>
            <a class="o" href="#">O</a>
            <a class="p" href="#">P</a>
            <a class="q ln-disabled" href="#">Q</a>
            <a class="r" href="#">R</a>
            <a class="s" href="#">S</a>
            <a class="t ln-disabled" href="#">T</a>
            <a class="u" href="#">U</a>
            <a class="v" href="#">V</a>
            <a class="w ln-disabled" href="#">W</a>
            <a class="x ln-disabled" href="#">X</a>
            <a class="y" href="#">Y</a>
            <a class="z ln-disabled ln-last" href="#">Z</a>
                                                                                  </div>
        <div class="ln-letter-count listNavHide" style="left: 494.581px; width: 47px; top: -14.9948px;">0</div>
    </div>
    <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-xlarge-1-3 uk-grid-medium listNavWrapper"
         id="contact_list_v2" data-uk-grid-match="{target:'.md-card'}">

        <? foreach ($companies as $company) {
            $echo = [];
            if ($company->users) {

                foreach ($company->users as $usr) {
                    $user = $usr->user;
                    if (array_search($user->id, $echo)) continue; else $echo[] = $user->id; ?>
                    <div class="uk-margin-medium-top ln-<?= strtolower(mb_substr($user->username, 0, 1, 'UTF-8')) ?>">
                        <div class="md-card md-card-hover md-card-horizontal" style="min-height: 237px;">
                            <div class="md-card-head">
                                <div class="md-card-head-menu" data-uk-dropdown="{pos:'bottom-left'}">
                                    <i class="md-icon material-icons"></i>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                            <li><a href="#"><?=Uni::t('app','Edit')?></a></li>
                                            <li><a href="#"><?=Uni::t('app','Remove')?></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="uk-text-center">
                                    <img class="md-card-head-avatar"
                                         src="/filemanager/uploads/?module=hr&folder=avatars&file=<?= $user->avatar ?>"
                                         alt="">
                                </div>
                                <h3 class="md-card-head-text uk-text-center">
                                    <?= $user->username ?><span class="listNavSelector"><?= $user->lastname ?></span>
                                    <span class="uk-text-truncate"><?= $company->short ?></span>
                                    <span class="uk-text-muted"><?= $company->name ?></span>
                                </h3>
                            </div>
                            <div class="md-card-content">
                                <ul class="md-list">
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?= Uni::t('app', 'Phone') ?></span>
                                            <span class="uk-text-small uk-text-muted uk-text-truncate">05<?= $user->phone ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?= Uni::t('app', 'Email') ?></span>
                                            <span class="uk-text-small uk-text-muted uk-text-truncate"><?= $user->email ?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?= Uni::t('app', 'INN') ?></span>
                                            <span class="uk-text-small uk-text-muted"><?= ($user->info) ? $user->info->inn : "" ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?
                }
            }

        } ?>
        <div class="uk-margin-medium-top">

            <a href="<?= $this->to('users/groups/add') ?>">
                <div class="md-card md-card-hover md-card-overlay" style="padding-left:0">
                    <div class="md-card-content">
                        <div class="epc_chart center-block" style="cursor:pointer">
                            <br/>
                            <img class="center-block" style="display:block;margin:auto;height: 50%"
                                 src="/themes/ui/icons/big-plus.svg"/>
                        </div>
                    </div>
            </a>
            <div class="md-card-overlay-content">
                <div class="uk-clearfix md-card-overlay-header">
                    <i class="md-icon material-icons md-card-overlay-toggler"></i>
                    <h3>
                        <?= Uni::t('app', 'Add') ?>
                    </h3>
                </div>
                <?= Uni::t('app', 'Add new employee') ?>
            </div>
        </div>
    </div>
</div>
<? } else { ?>

<? } ?>
