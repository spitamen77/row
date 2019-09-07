<?php
/**
 * Created by PhpStorm.
 * Author: Abdujalilov Dilshod
 * Telegram: https://t.me/coloterra
 * Web: http://code.uz
 * Date: 06.02.2019 17:43
 * Content: "Simplex CMS"
 * Site: http://simplex.uz
 */

\app\assets\CoreAssets::register($this);
//$this->title=Uni::t('app','You can learn anything');
use \uni\helpers\Html;
use app\components\manager\Url;
$block=Uni::$app->controller->block;
$top=Uni::$app->controller->top;
$bc=Uni::$app->controller->body_class;
$this->registerJs(' Muxr.stay_idle();');
$this->title = Uni::t('app', 'Forgot Password');
?>
<?php $this->beginPage() ?>
<?\app\components\widgets\Compressor::begin()?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="<?= Uni::$app->language ?>" class="no-js">
<!--<![endif]-->
<!-- start: HEAD -->
<head>
    <title><?=Html::encode($this->title) ?></title>
    <!-- start: META -->
    <meta charset="<?= Uni::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!--        <link rel="apple-touch-icon" sizes="57x57" href="/themes/frontend/icons/apple-icon-57x57.png">-->
    <link rel="apple-touch-icon" sizes="180x180" href="/themes/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/themes/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/themes/images/favicon-16x16.png">
    <link rel="manifest" href="/themes/images/site.webmanifest">
    <link rel="mask-icon" href="/themes/images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php $this->head() ?>
</head>
<!-- end: HEAD -->
<!-- start: BODY -->
<body class="sidebar_slim sidebar_slim_inactive <?=$bc?>">
<?php $this->beginBody() ?>
<!-- start: HEADER -->
<div class="login_page_wrapper uk-align-center" style="width: 400px;padding-bottom: 8px !important; ">
    <h2 class="uk-text-warning"><?=Uni::t('app', 'Email not found');?></h2>
    <div class="md-card uk-animation-15" id="login_card" style="min-height: 100%; opacity: 1; transform: scale(1);">


        <div class="md-card-content large-padding login-box" id="login_password_reset" style="">
            <!--                    <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>-->

            <form method="post" action="/ru/users/auth/forgot" class="user-for forgotpass-form text-center form-open form-active" id="forgot-password">
                <h1 class="form-heading"> <?=Uni::t('app', 'Forgot Password')?> </h1>
                <div class="form-group">
                    <input type="email" name="femail" class="md-input" id="femail" required="" placeholder="Email">
                    <i class="fa fa-envelope input-icon"></i>
                </div>

                <button type="submit" value="login" name="sign-up" class="md-btn md-btn-warning md-btn-block md-btn-large">
                    <?=Uni::t('app', 'Recover Password')?>
                </button>
                <p class="forgot-password margin-bottom-0">
                    <?=Uni::t('app', 'You have an account allready')?>?
                    <a class="login-frm-button margin-tp back_to_login" href="<?=Url::to('')?>"><?=Uni::t('app', 'Login')?></a>
                </p>
                <p class="status">
                </p>

                <!--                <input type="hidden" id="security3" name="security3" value="6f14922599">-->
                <!--                <input type="hidden" name="_wp_http_referer" value="/mytube/">-->
            </form>
        </div>


    </div>
</div>

<?php $this->endBody() ?>
</body>
<!-- end: BODY -->
</html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>
