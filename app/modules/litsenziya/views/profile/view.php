<?
use app\components\manager\Url;
$companies=Uni::$app->controller->companies;
?>
<div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
    <div class="uk-width-large-7-10">
        <div class="md-card">
            <div class="user_heading">
                <div class="user_heading_menu hidden-print">
                    <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons" id="page_print">&#xE8ad;</i></div>
                </div>
                <div class="user_heading_avatar">
                    <div class="thumbnail">
                        <img src="/filemanager/uploads/?module=hr&folder=avatars&file=<?=$user->avatar?>" alt="user avatar"/>
                    </div>
                </div>
                <div class="user_heading_content">
                    <h2 class="heading_b uk-margin-bottom">
                    <span class="uk-text-truncate"><?=$user->username?> <?=$user->lastname?></span>
                    <span class="sub-heading"><?=$user->getProfileStatus()?></span>
                    </h2>
                    <ul class="user_stats">
                        <li>
                            <h4 class="heading_a">2391 <span class="sub-heading"><?=Uni::t('app','Posts')?></span></h4>
                        </li>
                        <li>
                            <h4 class="heading_a">120 <span class="sub-heading"><?=Uni::t('app','Photos')?></span></h4>
                        </li>
                        <li>
                            <h4 class="heading_a">284 <span class="sub-heading"><?=Uni::t('app','Following')?></span></h4>
                        </li>
                    </ul>
                </div>
                <a class="md-fab md-fab-small md-fab-accent hidden-print" href="<?=$this->to('users/profile/edit/'.$user->id)?>">
                    <i class="material-icons">&#xE150;</i>
                </a>
            </div>
            <div class="user_content">
                <ul id="user_profile_tabs" class="uk-tab" data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}" data-uk-sticky="{ top: 48, media: 960 }">
                    <li class="uk-active"><a href="#"><?=Uni::t('app','About')?></a></li>
                    <li><a href="#"><?=Uni::t('app','Companies')?></a></li>
                    <li><a href="#"><?=Uni::t('app','Change password')?></a></li>
                </ul>
                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                    <li>
                        
                    <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin>
                            <div class="uk-width-large-1-2">
                                <h4 class="heading_c uk-margin-small-bottom"><?=Uni::t('app','Contact Info')?></h4>
                                <ul class="md-list md-list-addon">
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon material-icons">&#xE158;</i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?=$user->email?></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','Email')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon material-icons">&#xE0CD;</i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading">(998)<?=$user->phone?></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','Phone')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon uk-icon-check"></i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?=Uni::t('app','Verified users')?></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','Details')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon uk-icon-info"></i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?=Uni::t('app','Initials:')?></span>
                                            <span class="uk-text-small uk-text-muted"><?=$user->makeFIO()?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="uk-width-large-1-2">
                                <h4 class="heading_c uk-margin-small-bottom"><?=Uni::t('app','My last alerts')?></h4>
                                <ul class="md-list">
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#"><?=Uni::t('app','Cloud ')?>Computing</a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','84 Members')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#"><?=Uni::t('app','Account Manager Group')?></a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','21 Members')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#"><?=Uni::t('app','Digital Marketing')?></a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','44 Members')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#"><?=Uni::t('app','HR Professionals Association - Human Resources')?></a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','259 Members')?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>                    
                    </li>
                    <li>
                        <div id="user_profile_gallery" data-uk-check-display class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter: 4}">
                            <ul class="md-list">
                                <? foreach ($companies['all'] as $company) {?>
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="<?=Url::to("business/organizations/view/".$company->company_id)?>"><?=$company->company->name?></a></span>
                                            <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small"><?=date("Y-m-d H:s",$company->created)?></span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">12</span>
                                                </span>
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span class="uk-text-muted uk-text-small">926</span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                <?}?>
                            </ul>

                        </div>
                    </li>
                    <li>
                        <?php $form = \uni\ui\Form::begin(['id' => 'profile-form','options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data']]);?>
                        <input type="hidden" value="<?=$user->id?>" id="userid">
                        <div id="notvalidretype" style="display: none;" class="alert alert-danger"><?=Uni::t('app','Password confirmation is not valid')?></div>
                        <div id="successmes" style="display: none;" class="alert alert-success"></div>
                        <div class="form-group">
                            <label class="control-label">
                                <?=Uni::t('app','Password')?>
                            </label>
                            <input type="password" placeholder=" <?=Uni::t('app','Password')?>" class="md-input" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                <?=Uni::t('app','Confirm Password')?>
                            </label>
                            <input type="password" placeholder="<?=Uni::t('app','Confirm Password')?>" class="md-input" id="password_again" name="repassword">
                        </div>
                        <button type="button" id="updatepass" class="md-btn md-btn-success md-btn-block">
                            <?=Uni::t('app','Update')?> 
                        </button>
                        <?\uni\ui\Form::end() ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="uk-width-large-3-10 hidden-print">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-margin-medium-bottom">
                    <h3 class="heading_c uk-margin-bottom"><?=Uni::t('app','Alerts')?></h3>
                    <ul class="md-list md-list-addon">
                        <li>
                            <div class="md-list-addon-element">
                                <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading"><?=Uni::t('app','Delectus modi.')?></span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate"><?=Uni::t('app','Est ut ut et velit.')?></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-addon-element">
                                <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading"><?=Uni::t('app','Libero et.')?></span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate"><?=Uni::t('app','Incidunt repellendus ipsum neque aspernatur.')?></span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-addon-element">
                                <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>
                            </div>
                            <div class="md-list-content">
                                <span class="md-list-heading"><?=Uni::t('app','Facere ex.')?></span>
                                <span class="uk-text-small uk-text-muted uk-text-truncate"><?=Uni::t('app','Doloremque voluptatem voluptas accusamus rerum.')?></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <h3 class="heading_c uk-margin-bottom"><?=Uni::t('app','Friends')?></h3>
                <ul class="md-list md-list-addon uk-margin-bottom">
                    <li>
                        <div class="md-list-addon-element">
                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <span class="md-list-heading"><?=Uni::t('app','Jovani Kris MD')?></span>
                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','Molestias magni ab aut quisquam enim.')?></span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-addon-element">
                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <span class="md-list-heading"><?=Uni::t('app','Emelie Hand')?></span>
                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','Quia ratione totam hic.')?></span>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-addon-element">
                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_06_tn.png" alt=""/>
                        </div>
                        <div class="md-list-content">
                            <span class="md-list-heading"><?=Uni::t('app','Prof. Mary Pfannerstill')?></span>
                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app','Quia et nemo sit.')?></span>
                        </div>
                    </li>
                </ul>
                <a class="md-btn md-btn-flat md-btn-flat-primary" href="#"><?=Uni::t('app','Show all')?></a>
            </div>
        </div>
    </div>
</div>

