<?
use app\components\manager\Url;
$modul=Uni::$app->controller->cm;
$modul_id = Uni::$app->controller->id;
$user=Uni::$app->getUser()->identity;
?>
<!-- main sidebar -->
<aside id="sidebar_main">
    <div class="sidebar_main_header">
        <div class="sidebar_logo">
            <a href="<?=Url::to("")?>" class="sSidebar_hide sidebar_logo_large">
            </a>
            <a href="<?=Url::to("")?>" class="sSidebar_show sidebar_logo_small">
            </a>
        </div>
    </div>
    <div class="menu_section">
        <ul>

            <li <?=($modul=="main")?' class="current_section"':''?> title="<?=Uni::t('app','Dashboard')?>">
                <a href="<?=Url::to("")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE88A;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Dashboard')?></span>
                </a>
            </li>
            <?if(Uni::$app->access('ADMIN_TUM')){?>
            <li <?=($modul=="arrival")?' class="current_section"':''?> title="<?=Uni::t('app','Arrival')?>">
                <a href="<?=Url::to('settings/vktuman/prixod')?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Arrival')?></span>
                </a>
            </li>
             <li <?=($modul=="distribution")?' class="current_section"':''?> title="<?=Uni::t('app','Distribution')?>">
                <a href="<?=Url::to('users/default/tuman')?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Distribution')?></span>
                </a>
            </li>
            <?}?>
            <?if(Uni::$app->access('ADMIN_VIL')){?>
            <li <?=($modul=="arrival")?' class="current_section"':''?> title="<?=Uni::t('app','Arrival')?>">
                <a href="<?=Url::to('settings/vkviloyat/prixod')?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Arrival')?></span>
                </a>
            </li>
             <li <?=($modul=="distribution")?' class="current_section"':''?> title="<?=Uni::t('app','Distribution')?>">
                <a href="<?=Url::to('users/default/viloyat')?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Distribution')?></span>
                </a>
            </li>
            <?}?>
            <?if(Uni::$app->access('ADMIN')){?>
           <!--  <li <?=($modul=="accounting")?' class="current_section"':''?> title="<?=Uni::t('app','Accounting')?>">
                <a href="<?=Url::to("")?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Accounting')?></span>
                </a>
            </li> -->

            <li <?=($modul=="arrival")?' class="current_section"':''?> title="<?=Uni::t('app','Arrival')?>">
                <a href="<?=Url::to('settings/arrival/index')?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Arrival')?></span>

<!--            <li --><?//=($modul=="arrival")?' class="current_section"':''?><!-- title="--><?//=Uni::t('app','Arrival')?><!--">-->
<!--                <a href="--><?//=Url::to('settings/arrival/index')?><!--">-->
<!--                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>-->
<!--                    <span class="menu_title">--><?//=Uni::t('app','Arrival')?><!--</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            -->
<!--            <li --><?//=($modul=="distribution")?' class="current_section"':''?><!-- title="--><?//=Uni::t('app','Distribution')?><!--">-->
<!--                <a href="--><?//=Url::to('users/default/dashboard')?><!--">-->
<!--                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>-->
<!--                    <span class="menu_title">--><?//=Uni::t('app','Distribution')?><!--</span>-->
<!--                </a>-->
<!--            </li>-->
            <?}?>
            <li <?=($modul=="preparat")?' class="current_section"':''?> title="<?=Uni::t('app','Vaccine')?>">
                <a href="<?=$this->to('preparat')?>">
                    <span class="menu_icon"><i class="material-icons">&#xE02E;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Vaccine')?></span>
                </a>
            </li>

            <li <?=($modul=="distribution")?' class="current_section"':''?> title="<?=Uni::t('app','Distribution')?>">
                <a href="<?=Url::to('users/default/dashboard')?>">
                    <span class="menu_icon"><i class="material-icons">&#xe1ab;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Distribution')?></span>
                </a>
            </li>
            <li <?=($modul=="vaksinatsiya")?' class="current_section"':''?> title="<?=Uni::t('app','Vaksinatsiya')?>">
                <a href="<?=$this->to('vaksinatsiya')?>">
                    <span class="menu_icon"><i class="material-icons">&#xE02E;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Vaksinatsiya')?></span>
                </a>
            </li>
            <li <?=($modul=="reestr")?' class="current_section"':''?> title="<?=Uni::t('app','Cooperation')?>">
                <a href="#<?//=$this->to('reestr/default/index')?>">
                    <span class="menu_icon"><i class="material-icons">check_circle</i></span>
                    <span class="menu_title"><?=Uni::t('app','Cooperation')?></span>
                </a>
            </li>
            <li <?=($modul=="diagnose")?' class="current_section"':''?> title="<?=Uni::t('app','Diagnose')?>">
                <a href="<?=$this->to('diagnose')?>">
                    <span class="menu_icon"><i class="material-icons">playlist_add_check</i></span>
                    <span class="menu_title"><?=Uni::t('app','Diagnose')?></span>
                </a>
            </li>
            <li <?=($modul=="laboratory")?' class="current_section"':''?> title="<?=Uni::t('app','Reports')?>">
                <a href="<?=$this->to('report/default/index')?>">
                    <span class="menu_icon"><i class="material-icons">games</i></span>
                    <span class="menu_title"><?=Uni::t('app','Reports')?></span>
                </a>
            </li>

            <li <?=($modul=="hr")?' class="current_section"':''?> title="<?=Uni::t('app','Handbook')?>">
                <a href="#<?//=$this->to('hr/default/index')?>">
                    <span class="menu_icon"><i class="material-icons">group</i></span>
                    <span class="menu_title"><?=Uni::t('app','Handbook')?></span>
                </a>
            </li>

            <?if(Uni::$app->access('ADMIN')){?>
            <li <?=($modul=="ref")?' class="current_section"':''?> title="<?=Uni::t('app','Security')?>">
                <a href="<?=$this->to('reference/default/index')?>">
                    <span class="menu_icon"><i class="material-icons">settings_input_composite</i></span>
                    <span class="menu_title"><?=Uni::t('app','Security')?></span>
                </a>
            </li>

<!--            <li --><?//=($modul=="hr")?' class="current_section"':''?><!-- title="--><?//=Uni::t('app','Human resources')?><!--">-->
<!--                <a href="--><?//=$this->to('hr/default/index')?><!--">-->
<!--                    <span class="menu_icon"><i class="material-icons">group</i></span>-->
<!--                    <span class="menu_title">--><?//=Uni::t('app','Human resources')?><!--</span>-->
<!--                </a>-->
<!--            </li> -->

            <li <?=($modul_id=="reestr")?'class="current_section"':''?> title="<?=Uni::t('app','Owners')?>">
                <a href="#<?//=Url::to("reestr/default/index")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE04A;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Owners')?></span>
                </a>
            </li>
            <?}?>
<!--            <li --><?//=($modul_id=="notification")?'class="current_section"':''?><!-- title="--><?//=Uni::t('app','Notification')?><!--">-->
<!--                <a href="#--><?////=Url::to("reference/notification/index")?><!--">-->
<!--                    <span class="menu_icon"><i class="material-icons">&#xE04A;</i></span>-->
<!--                    <span class="menu_title">--><?//=Uni::t('app','Notification')?><!--</span>-->
<!--                </a>-->
<!--            </li>-->



            <?if(Uni::$app->access('ADMIN_VIL')){?>
            <!-- <li <?=($modul_id=="main")?'class="current_section"':''?> title="<?=Uni::t('app','Main')?>">
                <a href="<?=Url::to("settings/vkviloyat/index")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE0B9;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Main')?></span>
                </a>
            </li> -->
            <!-- <li <?=($modul=="report")?' class="current_section"':''?> title="<?=Uni::t('app','Report')?>">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE02F;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Report')?></span>
                </a>
                <ul>
                    <li <?=($modul_id=="arrival")?'class="current_section"':''?> title="<?=Uni::t('app','By regions')?>">
                        <a href="<?=Url::to("settings/vkviloyat/hisobot")?>">
                            <span class="menu_title"><?=Uni::t('app','By regions')?></span>
                        </a>
                    </li>
                    <li <?=($modul_id=="arrival")?'class="current_section"':''?> title="<?=Uni::t('app','By vaccinas')?>">
                        <a href="<?=Url::to("settings/vkviloyat/hisobot")?>">
                            <span class="menu_title"><?=Uni::t('app','By vaccinas')?></span>
                        </a>
                    </li>
                </ul>
            </li> -->
           <!--  <li <?=($modul_id=="kasturi")?'class="current_section"':''?> title="<?=Uni::t('app','Rasxod')?>">
                <a href="<?=Url::to("users/default/viloyat")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE04A;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Rasxod')?></span>
                </a>
            </li> -->
            <li <?=($modul_id=="disease")?'class="current_section"':''?> title="<?=Uni::t('app','Disease')?>">
                <a href="<?#=Url::to("users/default/viloyat")?>">
                    <span class="menu_icon"><i class="material-icons">&#xe85f;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Disease')?></span>
                </a>
            </li>
            <li <?=($modul_id=="reestr")?'class="current_section"':''?> title="<?=Uni::t('app','Reestr')?>">
                <a href="<?=Url::to("reestr/default/index")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE04A;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Reestr')?></span>
                </a>
            </li>
            <li <?=($modul_id=="notification")?'class="current_section"':''?> title="<?=Uni::t('app','Notification')?>">
                <a href="<?#=Url::to("reference/notification/index")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE04A;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Notification')?></span>
                </a>
            </li>
            <li <?=($modul_id=="arrival")?'class="current_section"':''?> title="<?=Uni::t('app','Users')?>">
                <a href="<?=Url::to("settings/vkviloyat/users")?>">
                    <span class="menu_icon"><i class="material-icons">&#xE0B9;</i></span>
                    <span class="menu_title"><?=Uni::t('app','Users')?></span>
                </a>
            </li>
            <?}?>

<!--            <li --><?//=($modul_id=="unitmea")?'class="current_section"':''?><!-- title="--><?//=Uni::t('app','Unit measure')?><!--">-->
<!--                <a href="--><?//=Url::to("settings/unitmea/index")?><!--">-->
<!--                    <span class="menu_icon"><i class="material-icons">&#xE0B9;</i></span>-->
<!--                    <span class="menu_title">--><?//=Uni::t('app','Unit measure')?><!--</span>-->
<!--                </a>-->
<!--            </li>-->
            <?if(Uni::$app->access('ADMIN')){?>
                <li <?=($modul=="cpanel")?' class="current_section"':''?> title="<?=Uni::t('app','Control panel')?>">
                    <a href="<?=Url::to("cpanel")?>">
                        <span class="menu_icon"><i class="material-icons">&#xE8A4;</i></span>
                        <span class="menu_title"><?=Uni::t('app','Control panel')?></span>
                    </a>
<!--                    <ul>-->
<!--                        <li><a href="--><?//=Url::to("cpanel")?><!--">--><?//=Uni::t('app','Main')?><!--</a></li>-->
<!--                        <li><a href="--><?//=Url::to("cpanel/default/modules")?><!--">--><?//=Uni::t('app','Modules')?><!--</a></li>-->
<!--                         <li><a href="--><?//=Url::to("cpanel/users/index")?><!--">--><?//=Uni::t('app','Users')?><!--</a></li> -->
<!--                    </ul>-->
                </li>
            <?}?>
            <!----------------------------------------- Tuman USER start -------------------------------------->
            <?if(Uni::$app->access('TUM')){?>

            <?}?>
            <!----------------------------------------- Tuman USER end -------------------------------------->






        </ul>
    </div>
</aside>
