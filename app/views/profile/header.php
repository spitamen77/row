<?
use app\components\manager\Url;
use app\models\UserModel;
use app\models\Speciality;
use app\models\SubjectCategory;

//use Uni;
if (! Uni::$app->user->isGuest) {
    $currentUserName = Uni::$app->getUser()->getIdentity()->username;
}
else {
    $currentUserName = 'Guest';
}
$speciality = Speciality::find()->where(['status'=>1])->all();
$subcat = SubjectCategory::find()->where(['status'=>1])->all();
?>


<div class="top-bar main-site-color full-topbar" id="main-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-5 col-xs-8">
                <div class="menu-bars menu2-bars">
                    <span class="bars-holder">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </span>
                    <ul id="menu-header" class="menu-header">
                        <li id="menu-item-1191" class="fa fa-home menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-has-children menu-item-1191"><a href="<?=Url::to('')?>">Bosh sahifa</a>
                        </li>
                        <li id="menu-item-1102" class="fa fa-paper-plane-o menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1102"><a href="#">Fanlar</a>
                            <ul  class="sub-menu">
                                <? foreach ($subcat as $cat) {?>
                                <li id="menu-item-1116" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1116"><a href="<?=$this::to('page/subject/view/').$cat->id?>"><?=$cat->title?></a></li>
                                <? } ?>
                                <li id="menu-item-1114" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1114"><a href="<?=$this::to('page/video/umumtalim')?>">Umumta'lim fanlar</a></li>
                                <li id="menu-item-1115" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1115"><a href="<?=$this::to('page/video/maxsus')?>">Maxsus fanlar</a></li>
                                <li id="menu-item-1115" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1115"><a href="<?=$this::to('page/video/amaliyot')?>">O'quv amaliyoti</a></li>
                            </ul>
                        </li>
                        <li id="menu-item-1103" class="fa fa-cube menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1103"><a href="#">Sohalar</a>
                            <ul  class="sub-menu">
                                <? foreach ($speciality as $val) {?>
                                    <li id="menu-item-1119" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1119">
                                        <a href="<?=$this::to('page/speciality/list/').$val->id?>"><?=$val->title?></a>
                                    </li>
                                <?} ?>

                            </ul>
                        </li>


                    </ul>
                </div>
                <div class="logo">
                    <div class="jw-logo"><a class="logo-link" href="<?=$this->to('page/video/index')?>"><img src="/themes/kasb/img/logo.png" width="160px" alt="Kasb hunar"></a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-sm-12 col-xs-12 sm-border-top mobile-search header-search">
                <div class="top-search pos-relative">
                    <div class="search-container">
                        <form class="searchbox navbar-form" method="get" action="#">
                            <input type="text" class="searchbox-input search" placeholder="Qidirish ..." name="s" required autocomplete="off">
                            <input type="hidden" name="post_type" value="video">
                            <button type="submit" class="searchbox-submit searchbox-icon" value="">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 sm-border-top text-right hidden-sm">
                <div class="">
                    <div class="login-reg">
                        <div class="login">
                            <div class="media">
                                <div class="media-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 513.32 513.32" xml:space="preserve" width="512px" height="512px" class="img-responsive play-svg svg replaced-svg"><g><g><path d="M346.491,316.547c49.193-29.944,81.275-83.414,81.275-145.44C427.767,76.998,350.768,0,256.66,0 S85.553,76.998,85.553,171.107c0,62.026,32.082,115.497,81.275,145.44C81.275,348.63,17.11,423.489,0,513.32h42.777 c21.388-98.386,109.081-171.107,213.883-171.107s192.495,72.72,213.883,171.107h42.777 C496.21,421.35,432.045,346.491,346.491,316.547z M128.33,171.107c0-70.581,57.749-128.33,128.33-128.33 s128.33,57.749,128.33,128.33s-57.749,128.33-128.33,128.33S128.33,241.688,128.33,171.107z" fill="#d82727"></path></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                                </div>
                                <div class="media-body">
                                    <?if(Uni::$app->getUser()->isGuest){?>
                                        <p>
                                            <a class="login-toggle" href="#">Login</a>
                                        </p>
                                    <?}else{?>

                                        <p>
                                            <a class="" href="<?=$this->to('users/course/main')?>"><?=Uni::t('app','Profil')?></a> /
                                            <a class="" href="<?=$this->to('users/auth/logout')?>"><?=Uni::t('app','Chiqish')?></a>
                                        </p>
                                    <?}?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="full-topbar-recover"></div>
<div class="clearfix"></div>
<div class="user-profile-holder">
    <!-- Nav tabs -->
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs profile-tabs" role="tablist">
                <? if(Uni::$app->access('STD')){ ?>
                <li role="presentation"><a href="<?=Url::to('users/kasb/index')?>"><i class="fa fa-plus"></i><?=Uni::t('app', 'Kasblarim')?></a></li>
                <li role="presentation"><a href="<?=Url::to('users/subject/mysubject')?>"><i class="fa fa-plus"></i><?=Uni::t('app', 'Fanlarim')?></a></li>
                <li role="presentation"><a href="<?=Url::to('users/course/mycourse')?>"><i class="fa fa-plus"></i><?=Uni::t('app', 'Kurslarim')?></a></li>
                <li role="presentation"><a href="<?=Url::to('users/kasb/sertificate')?>"><i class="fa fa-plus"></i><?=Uni::t('app', 'Mening kasblarim')?></a></li>
                <?}?>
                <? if(Uni::$app->access('TECH')){ ?>
                <li role="presentation"><a href="<?=Url::to('users/course/index')?>"><i class="fa fa-plus"></i><?=Uni::t('app', 'Kurslar')?></a></li>
                <li role="presentation"><a href="<?=Url::to('users/kasb/comment')?>"><i class="fa fa-plus"></i><?=Uni::t('app', 'Izohlar')?></a></li>
                <?}?>
                
                <li role="presentation"><a href="<?=$this->to('users/notification/index')?>"><i class="fa fa-video-camera"></i><?=Uni::t('app', 'Xabarlar')?></a></li>
                
                <li role="presentation"><a href="<?=$this->to('users/kasb/reyting')?>"><i class="fa fa-eye-slash"></i><?=Uni::t('app', 'Reytinglar')?></a></li>
                
                <li role="presentation"><a href="<?=Url::to('users/course/main')?>"><i class="fa fa-user"></i><?=Uni::t('app', 'Profil')?></a></li>
                <!-- <li role="presentation"><a href="#"><i class="fa fa-power-off"></i>Logout</a></li> -->
                <li role="presentation"><a href="<?=Url::to('users/profile/eslatma')?>"><i class="fa fa-power-off"></i>Foydalanish shartlari</a></li>
            </ul>
        </div>
    </div>
</div>