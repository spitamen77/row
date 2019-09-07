<?
use app\components\manager\Url;
$user=Uni::$app->getUser()->getIdentity();

$messages=Uni::$app->session->getAllFlashes();
if(!empty($messages)){?>
    <?foreach($messages as $key=>$val){
        $arr=explode("_",$key);
        $tp=end($arr);
        $url=false;
        if($tp=="sweetalert"){
            $con=explode("#",$val);
            $config=[];
            foreach($con as $c){
                $c=explode("=",$c);
                if($c[0]=="curl"){
                    $url=$c[1];
                    $fun="function(isConfirm){if (isConfirm){ window.location.replace(\"".$url."\");}} ";
                    $config["confirmfunction"]=$fun;
                }else
                    $config[$c[0]]=$c[1];
            }

            echo \app\components\widgets\SweetAlert::widget($config);

        }else{
            $this->registerJs("Muxr.showNotify({message:".$val.",status:'".$tp."'});");
        }
    }
}
$id_user = Uni::$app->getUser()->getId();
$diagram = \app\models\Notification::find()->where(['user_id'=>$id_user, 'status'=>1])->orderBy(['id'=>SORT_DESC])->asArray()->all();
if (!empty($diagram)){
    $notific = count($diagram);
}
else $notific = false;
//var_dump($diagram); die;
?>
<style type="text/css">
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        outline: 0!important;
    }

    .notify {
        position: relative;
        margin-top: -25px;
        margin-right: 15px;
    }

    .notify .heartbit {
        position: absolute;
        top: -20px;
        right: -16px;
        height: 25px;
        width: 25px;
        z-index: 10;
        border: 5px solid #fb9678;
        border-radius: 70px;
        -moz-animation: heartbit 1s ease-out;
        -moz-animation-iteration-count: infinite;
        -o-animation: heartbit 1s ease-out;
        -o-animation-iteration-count: infinite;
        -webkit-animation: heartbit 1s ease-out;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite
    }

    .notify .point {
        width: 6px;
        height: 6px;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;
        border-radius: 30px;
        background-color: #fb9678;
        position: absolute;
        right: -6px;
        top: -10px
    }

    @-moz-keyframes heartbit {
        0% {
            -moz-transform: scale(0);
            opacity: 0
        }
        25% {
            -moz-transform: scale(.1);
            opacity: .1
        }
        50% {
            -moz-transform: scale(.5);
            opacity: .3
        }
        75% {
            -moz-transform: scale(.8);
            opacity: .5
        }
        100% {
            -moz-transform: scale(1);
            opacity: 0
        }
    }

    @-webkit-keyframes heartbit {
        0% {
            -webkit-transform: scale(0);
            opacity: 0
        }
        25% {
            -webkit-transform: scale(.1);
            opacity: .1
        }
        50% {
            -webkit-transform: scale(.5);
            opacity: .3
        }
        75% {
            -webkit-transform: scale(.8);
            opacity: .5
        }
        100% {
            -webkit-transform: scale(1);
            opacity: 0
        }
    }
</style>

<header id="header_main">
    <div class="header_main_content">
        <nav class="uk-navbar">

            <!-- main sidebar switch -->
            <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                <span class="sSwitchIcon"></span>
            </a>

            <!-- secondary sidebar switch -->
            <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                <span class="sSwitchIcon"></span>
            </a>

            <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
               <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                   <a href="#" class="top_menu_toggle"><i class="material-icons md-24">&#xE8F0;</i></a>
                   <!-- <div class="uk-dropdown uk-dropdown-width-3">
                       <div class="uk-grid uk-dropdown-grid">
                           <div class="uk-width-2-3">
                               <div class="uk-grid uk-grid-width-medium-1-3 uk-margin-bottom uk-text-center">
                                   <a href="#" class="uk-margin-top">
                                       <i class="material-icons md-36 md-color-light-green-600">&#xE158;</i>
                                       <span class="uk-text-muted uk-display-block">Mailbox</span>
                                   </a>
                                   <a href="#" class="uk-margin-top">
                                       <i class="material-icons md-36 md-color-purple-600">&#xE53E;</i>
                                       <span class="uk-text-muted uk-display-block">Invoices</span>
                                   </a>
                                   <a href="#" class="uk-margin-top">
                                       <i class="material-icons md-36 md-color-cyan-600">&#xE0B9;</i>
                                       <span class="uk-text-muted uk-display-block">Chat</span>
                                   </a>
                                   <a href="#" class="uk-margin-top">
                                       <i class="material-icons md-36 md-color-red-600">&#xE85C;</i>
                                       <span class="uk-text-muted uk-display-block">Scrum Board</span>
                                   </a>
                                   <a href="#" class="uk-margin-top">
                                       <i class="material-icons md-36 md-color-blue-600">&#xE86F;</i>
                                       <span class="uk-text-muted uk-display-block">Snippets</span>
                                   </a>
                                   <a href="#" class="uk-margin-top">
                                       <i class="material-icons md-36 md-color-orange-600">&#xE87C;</i>
                                       <span class="uk-text-muted uk-display-block">User profile</span>
                                   </a>
                               </div>
                           </div>
                           <div class="uk-width-1-3">
                               <ul class="uk-nav uk-nav-dropdown uk-panel">
                                   <li class="uk-nav-header">Components</li>
                                   <li><a href="#">Accordions</a></li>
                                   <li><a href="#">Buttons</a></li>
                                   <li><a href="#">Notifications</a></li>
                                   <li><a href="#">Sortable</a></li>
                                   <li><a href="#">Tabs</a></li>
                               </ul>
                           </div>
                       </div>
                   </div> -->
               </div>
                <div class="uk-button-dropdown">
                    <a href="<?=(Uni::$app->language=='ru') ? '/uz' : '/ru'?>" class="user_action_image">
                        <img class="md-user-image" style="height: 20px; width: 25px; margin-top: 5px" src="<?= (Uni::$app->language=='ru') ? "/themes/images/uz.png" : "/themes/images/ru.png" ?>" alt="<?=$user->username?>"/>
                    </a>

                </div>
            </div>


            <div class="uk-navbar-flip">
                <ul class="uk-navbar-nav user_actions">
<!--                    <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>-->
<!--                    <li><a href="#" id="main_search_btn" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE8B6;</i></a></li>-->
                    <li><a><?php
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

                            ?></a></li>
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i>
<!--                            <span class="uk-badge">0</span>-->
                        </a>
                        <?php if ($notific):  ?>
                            <div class="notify">
                                <span class="heartbit"></span>
                                <span class="point"></span>
                            </div>
                        <?php endif; ?>
                        <div class="uk-dropdown uk-dropdown-xlarge">
                            <div class="md-card-content">
                                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                    <li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small"><?=Uni::t('app', 'Messages')?> (<?=($notific)?$notific:0?>)</a></li>
                                    <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small"><?=Uni::t('app', 'Alerts')?> (0)</a></li>
                                </ul>
                                <ul id="header_alerts" class="uk-switcher uk-margin">
                                    <li>
                                        <?php if ($notific):?>
                                        <table class="uk-table uk-table-nowrap table_check">
                                            <thead>

                                            <tr>
                                                <th class="uk-width-2-3"><?= Uni::t('app', 'Message') ?></th>
                                                <th class="uk-width-1-3 uk-text-center"><?= Uni::t('app', 'Property') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($diagram as $items):?>
                                                <tr class="md-btn-flat md-btn-flat-primary js-uk-prevent">
                                                    <td class="uk-width-2-3">
                                                        <div class="uk-margin-top">
                                                            <a href="<?=Url::to($items["action_page"]."?notific=".$items['id'])?>"><b><?=Uni::t('app', $items['message'])?></b></a>
                                                        </div>
                                                    </td>
                                                    <td class="uk-width-1-3">
                                                        <div class="uk-margin-top">
                                                            <a href="<?=Url::to($items["action_page"]."?notific=".$items['id'])?>"><?=date("d-m-Y",$items["created_date"])?></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>

                                        </table>
                                            <a data-id="<?=$id_user?>" id="notific"> <span class="uk-text-small uk-text-muted uk-text-truncate uk-text-center">
                                                <?=Uni::t('app', 'Read all')?>&nbsp;<i class="material-icons">done_all</i>
                                            </span></a>
                                        <?php else: ?>
                                        <div class="uk-margin-top uk-text-center">
                                            <a class="">
                                                <i class="md-list-addon-icon material-icons uk-text-success">thumb_up</i>
                                                <i class="md-list-addon-icon material-icons uk-text-success">sentiment_satisfied_alt</i>
                                            </a>
                                        </div>
                                        <?php endif;?>

                                    </li>
                                    <li>
                                        <ul class="md-list md-list-addon">
                                            <li>
                                                <div class="md-list-addon-element">
                                                    <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                                                </div>
                                                <div class="md-list-content">
                                                    <span class="md-list-heading">Corrupti expedita.</span>
                                                    <span class="uk-text-small uk-text-muted uk-text-truncate">Sed pariatur sunt non aut.</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <a href="#" class="user_action_image">
                            <img class="md-user-image" src="<?= (!empty($user->avatar)) ? $user->avatar : "/themes/ui/assets/img/avatars/user.png" ?>" alt="<?=$user->username?>"/>
                            <?if(Uni::$app->controller->access('ADMIN_TUMAN')){?>
                                <??>
                            <?}?>
                        </a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                <li><a href="<?=Url::to('users/profile/view')?>"><?=Uni::t('app', 'My profile')?></a></li>
                                <li><a href="<?=Url::to('users/profile/edit')?>"><?=Uni::t('app', 'Settings')?></a></li>
                                <li><a href="<?=Url::to('users/auth/logout')?>"><?=Uni::t('app', 'Logout')?></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="header_main_search_form">
        <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
        <form class="uk-form uk-autocomplete" data-uk-autocomplete="{source:'data/search_data.json'}">
            <input type="text" class="header_main_search_input" />
            <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i></button>
            <script type="text/autocomplete">
                    <ul class="uk-nav uk-nav-autocomplete uk-autocomplete-results">
                    </ul>
                </script>
        </form>
    </div>
</header><!-- main header end -->

<?php
$this->registerJs('
 $(document).ready(function(){
    $("#notific").click(function(){
        var data = $(this).attr("data-id");
        $.get("/users/profile/notific",{notific: data},function(response){
            if(response=="success") window.location.reload();
            else alert(response);
        });
    });
});
');
?>