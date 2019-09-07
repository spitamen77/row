<?
use app\components\manager\Url;
//$groups = [];
//$gr = \app\models\Groups::find()->where(['active' => 1])->all();
//if ($gr) $groups = $gr;
$this->title = $user->username . " - " . Uni::t('app', 'profile');
?>
<div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
    <div class="uk-width-large-7-10">
    <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("cpanel/users/index")?>"><?=Uni::t('app','Users')?></a>
    </div><br>
    <div class="md-card">
        <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <div class="user_heading_menu hidden-print">

                <div class="uk-display-inline-block"><i class="md-icon md-icon-light material-icons"
                                                        id="page_print"></i></div>
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
            <a class="md-fab md-fab-small md-fab-accent hidden-print" href="<?=\uni\helpers\Url::to("../../../cpanel/users/edit/$user->id")?>">
                <i class="material-icons"></i>
            </a>
        </div>
        <div class="user_content">
            <ul id="user_profile_tabs" class="uk-tab"
                data-uk-tab="{connect:'#user_profile_tabs_content', animation:'slide-horizontal'}">
                <li class="uk-active"><a href="#"><?=Uni::t('app', 'About')?></a></li>
<!--                <li><a href="#">Photos</a></li>-->
                <li><a href="#"><?=Uni::t('app', 'History')?></a></li>
            </ul>
            <ul id="user_profile_tabs_content" class="uk-switcher uk-margin">
                <li>
                    <?=Uni::t('app', 'Welcome to the User profile')?>!
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
<!--                <li>-->
<!--                    <div id="user_profile_gallery" data-uk-check-display=""-->
<!--                         class="uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4"-->
<!--                         data-uk-grid="{gutter: 4}">-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image01.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image01.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image02.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image02.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image03.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image03.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image04.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image04.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image05.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image05.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image06.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image06.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image07.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image07.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image08.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image08.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image09.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image09.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image10.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image10.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image11.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image11.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image12.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image12.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image13.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image13.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image14.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image14.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image15.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image15.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image16.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image16.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image17.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image17.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image18.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image18.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image19.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image19.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image20.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image20.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image21.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image21.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image22.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image22.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image23.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image23.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div>-->
<!--                            <a href="assets/img/gallery/Image24.jpg" data-uk-lightbox="{group:'user-photos'}">-->
<!--                                <img src="assets/img/gallery/Image24.jpg" alt="">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <ul class="uk-pagination uk-margin-large-top">-->
<!--                        <li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>-->
<!--                        <li class="uk-active"><span>1</span></li>-->
<!--                        <li><a href="#">2</a></li>-->
<!--                        <li><a href="#">3</a></li>-->
<!--                        <li><a href="#">4</a></li>-->
<!--                        <li><span>…</span></li>-->
<!--                        <li><a href="#">20</a></li>-->
<!--                        <li><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>-->
<!--                    </ul>-->
<!--                </li>-->
                <li>
                    <ul class="md-list">
                        <!-- <li>
                            <div class="md-list-content">
                                <span class="md-list-heading"><a href="#">Labore consequuntur provident dolorem nostrum qui.</a></span>
                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                            class="uk-text-muted uk-text-small">27 Jul 2018</span>
                                                </span>
                                    <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                class="uk-text-muted uk-text-small">9</span>
                                                </span>
                                    <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                class="uk-text-muted uk-text-small">796</span>
                                                </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="md-list-heading"><a href="#">Magni quia voluptatibus consequatur rerum doloremque aut esse aut.</a></span>
                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                            class="uk-text-muted uk-text-small">22 Jul 2018</span>
                                                </span>
                                    <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                class="uk-text-muted uk-text-small">22</span>
                                                </span>
                                    <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                class="uk-text-muted uk-text-small">567</span>
                                                </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="md-list-heading"><a href="#">Repudiandae est iure ea sequi illo et magnam incidunt.</a></span>
                                <div class="uk-margin-small-top">
                                                <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                            class="uk-text-muted uk-text-small">06 Jul 2018</span>
                                                </span>
                                    <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                class="uk-text-muted uk-text-small">5</span>
                                                </span>
                                    <span class="uk-margin-right">
                                                    <i class="material-icons"></i> <span
                                                class="uk-text-muted uk-text-small">966</span>
                                                </span>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    </div>
</div>
