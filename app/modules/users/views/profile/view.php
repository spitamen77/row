<?

use app\components\manager\Url;
use uni\ui\Form;

//$companies=Uni::$app->controller->companies;
$this->title = Uni::t('app', 'My account');
?>
<div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
    <div class="uk-width-large-7-10">
        <div class="md-card">
            <div class="user_heading">
                <div class="user_heading_menu hidden-print">
                    <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons"
                                                            id="page_print">&#xE8ad;</i></div>
                </div>
                <div class="user_heading_avatar fileinput fileinput-new">
                    <div class="fileinput-new thumbnail">
                        <img src="<?= (!empty($user->avatar)) ? $user->avatar : "/themes/ui/assets/img/avatars/user.png" ?>"
                             alt="user avatar"/>
                    </div>
                </div>
                <div class="user_heading_content">
                    <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?= $user->lastname ?> <?= $user->username ?></span>
                        <span class="sub-heading" style="font-size: 14px"><?= $user->roles->title ?></span></>
                    <ul class="user_stats">
                        <li>
                            <h4 class="heading_a"><?=Uni::t('app', 'Created')?> <span class="sub-heading"><?=date("d-m-Y", $user->created)?></span></h4>
                        </li>
                        <li>
                            <h4 class="heading_a"><?=Uni::t('app', 'Last visit')?> <span class="sub-heading"><?=($user->logged==null)? Uni::t('app', 'No visit'): date("d-m-Y", $user->logged)?></span></h4>
                        </li>

                    </ul>
                </div>
                <a class="md-fab md-fab-small md-fab-accent hidden-print"
                   href="<?= $this->to('users/profile/edit/' . $user->id) ?>">
                    <i class="material-icons">&#xE150;</i>
                </a>
            </div>
            <div class="user_content">
                <ul id="user_profile_tabs" class="uk-tab"
                    data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}"
                    data-uk-sticky="{ top: 48, media: 960 }">
                    <li class="uk-active"><a href="#"><?= Uni::t('app', 'About') ?></a></li>
<!--                    <li><a href="#">--><?//= Uni::t('app', 'Photo') ?><!--</a></li>-->
                    <li><a href="#"><?= Uni::t('app', 'Change password') ?></a></li>
                </ul>
                <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                    <li>
                        <?=Uni::t('app', 'Welcome to the User profile')?>!<br>
                        <span style="color: red"><?=(!empty($xabar))?$xabar:""?></span>
                        <div class="uk-grid uk-margin-medium-top uk-margin-large-bottom" data-uk-grid-margin="">
                            <div class="uk-width-large-1-2">
                                <h4 class="heading_c uk-margin-small-bottom"><?=Uni::t('app', 'Contact Info')?></h4>
                                <ul class="md-list md-list-addon">
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon uk-icon-reorder"></i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?=($user->viloyat_id==0)?Uni::t('app', 'Not set'):$user->viloyat->name?></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app', 'Region')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon uk-icon-home"></i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><?=($user->tuman_id==0)?Uni::t('app', 'Not set'):$user->tuman->name?></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app', 'City')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon material-icons"></i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="tel:<?=$user->phone?>"> <?=$user->phone?></a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app', 'Phone')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-addon-element">
                                            <i class="md-list-addon-icon material-icons"></i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="mailto:<?=($user->email)?$user->email:'';?>" class="__cf_email__"><?=($user->email)?$user->email:'';?></a></span>
                                            <span class="uk-text-small uk-text-muted">Email</span>
                                        </div>
                                    </li>


                                </ul>
                            </div>
                            <div class="uk-width-large-1-2">
                                <h4 class="heading_c uk-margin-small-bottom"><?=Uni::t('app', 'Status')?></h4>
                                <ul class="md-list">
                                    <li>
                                        <div class="md-list-content">
                                            <span class="md-list-heading"><a href="#"><?=$user->roles->title?></a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app', 'User group')?></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="md-list-content">
                                        <span class="md-list-heading"><a href="#"><?php
                                                switch ($user->status) {
                                                    case 0:
                                                        echo Uni::t('app', 'Blocked');
                                                        break;
                                                    case 1:
                                                        echo Uni::t('app', 'Active');
                                                        break;
                                                    case 9:
                                                        echo Uni::t('app', 'Deleted');
                                                        break;
                                                    default:
                                                        echo Uni::t('app', 'Undefined');
                                                }
                                                ?></a></span>
                                            <span class="uk-text-small uk-text-muted"><?=Uni::t('app', 'User status')?></span>
                                        </div>
                                    </li>
                                    <!--                                <li>-->
                                    <!--                                    <div class="md-list-content">-->
                                    <!--                                        <span class="md-list-heading"><a href="#">Digital Marketing</a></span>-->
                                    <!--                                        <span class="uk-text-small uk-text-muted">150 Members</span>-->
                                    <!--                                    </div>-->
                                    <!--                                </li>-->
                                    <!--                                <li>-->
                                    <!--                                    <div class="md-list-content">-->
                                    <!--                                        <span class="md-list-heading"><a href="#">HR Professionals Association - Human Resources</a></span>-->
                                    <!--                                        <span class="uk-text-small uk-text-muted">78 Members</span>-->
                                    <!--                                    </div>-->
                                    <!--                                </li>-->
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <? $form = Form::begin([
                            'enableClientValidation' => true,
//                'enableAjaxValidation' => true,
                            'options' => ['class' => 'model-form']
                        ]); ?>
                            <h5><?= Uni::t('app', 'Personal Information') ?></h5>
                                <div class="form-group">
<!--                                        <label class="control-label">--><?//=Uni::t('app','Current password')?><!--</label>-->
                                        <input type="password" class="md-input" name="password" placeholder="<?=Uni::t('app','Enter old password')?>"/>
                                        <div class="help-block"></div>
                                </div>
                                <div class="form-group">
<!--                                    <label class="control-label">--><?//=Uni::t('app','New password')?><!--</label>-->
                                    <input type="password" class="md-input" name="newpassword" placeholder="<?=Uni::t('app','Enter new password')?>"/>
                                </div>
                                <div class="form-group">
<!--                                    <label class="control-label">--><?//=Uni::t('app','Confirm new password')?><!--</label>-->
                                    <input type="password" class="md-input" name="confirm" placeholder="<?=Uni::t('app','Confirm new password')?>"/>
                                </div>
                            <div class="form-group">
                                <button type="submit" class="md-btn md-btn-success md-btn-block"><?= Uni::t('app', 'Save') ?></button>
                            </div>
                        <? Form::end() ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--    <div class="uk-width-large-3-10 hidden-print">-->
    <!--        <div class="md-card">-->
    <!--            <div class="md-card-content">-->
    <!--                <div class="uk-margin-medium-bottom">-->
    <!--                    <h3 class="heading_c uk-margin-bottom">--><? //=Uni::t('app','Alerts')?><!--</h3>-->
    <!--                    <ul class="md-list md-list-addon">-->
    <!--                        <li>-->
    <!--                            <div class="md-list-addon-element">-->
    <!--                                <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>-->
    <!--                            </div>-->
    <!--                            <div class="md-list-content">-->
    <!--                                <span class="md-list-heading">-->
    <? //=Uni::t('app','Delectus modi.')?><!--</span>-->
    <!--                                <span class="uk-text-small uk-text-muted uk-text-truncate">-->
    <? //=Uni::t('app','Est ut ut et velit.')?><!--</span>-->
    <!--                            </div>-->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="md-list-addon-element">-->
    <!--                                <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i>-->
    <!--                            </div>-->
    <!--                            <div class="md-list-content">-->
    <!--                                <span class="md-list-heading">-->
    <? //=Uni::t('app','Libero et.')?><!--</span>-->
    <!--                                <span class="uk-text-small uk-text-muted uk-text-truncate">-->
    <? //=Uni::t('app','Incidunt repellendus ipsum neque aspernatur.')?><!--</span>-->
    <!--                            </div>-->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="md-list-addon-element">-->
    <!--                                <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>-->
    <!--                            </div>-->
    <!--                            <div class="md-list-content">-->
    <!--                                <span class="md-list-heading">-->
    <? //=Uni::t('app','Facere ex.')?><!--</span>-->
    <!--                                <span class="uk-text-small uk-text-muted uk-text-truncate">-->
    <? //=Uni::t('app','Doloremque voluptatem voluptas accusamus rerum.')?><!--</span>-->
    <!--                            </div>-->
    <!--                        </li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--                <h3 class="heading_c uk-margin-bottom">--><? //=Uni::t('app','Friends')?><!--</h3>-->
    <!--                <ul class="md-list md-list-addon uk-margin-bottom">-->
    <!--                    <li>-->
    <!--                        <div class="md-list-addon-element">-->
    <!--                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_02_tn.png" alt=""/>-->
    <!--                        </div>-->
    <!--                        <div class="md-list-content">-->
    <!--                            <span class="md-list-heading">-->
    <? //=Uni::t('app','Jovani Kris MD')?><!--</span>-->
    <!--                            <span class="uk-text-small uk-text-muted">-->
    <? //=Uni::t('app','Molestias magni ab aut quisquam enim.')?><!--</span>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li>-->
    <!--                        <div class="md-list-addon-element">-->
    <!--                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>-->
    <!--                        </div>-->
    <!--                        <div class="md-list-content">-->
    <!--                            <span class="md-list-heading">--><? //=Uni::t('app','Emelie Hand')?><!--</span>-->
    <!--                            <span class="uk-text-small uk-text-muted">-->
    <? //=Uni::t('app','Quia ratione totam hic.')?><!--</span>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                    <li>-->
    <!--                        <div class="md-list-addon-element">-->
    <!--                            <img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_06_tn.png" alt=""/>-->
    <!--                        </div>-->
    <!--                        <div class="md-list-content">-->
    <!--                            <span class="md-list-heading">-->
    <? //=Uni::t('app','Prof. Mary Pfannerstill')?><!--</span>-->
    <!--                            <span class="uk-text-small uk-text-muted">-->
    <? //=Uni::t('app','Quia et nemo sit.')?><!--</span>-->
    <!--                        </div>-->
    <!--                    </li>-->
    <!--                </ul>-->
    <!--                <a class="md-btn md-btn-flat md-btn-flat-primary" href="#">-->
    <? //=Uni::t('app','Show all')?><!--</a>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
</div>

