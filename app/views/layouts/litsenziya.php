<?
\app\assets\LitsenziyaAssets::register($this);
$this->title=Uni::t('app','You can learn anything');
use \uni\helpers\Html;
use app\components\manager\Url;

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
        <link rel="apple-touch-icon" sizes="57x57" href="/themes/frontend/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/themes/frontend/icons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/themes/frontend/icons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/themes/frontend/icons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/themes/frontend/icons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/themes/frontend/icons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/themes/frontend/icons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/themes/frontend/icons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/themes/frontend/icons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/themes/frontend/icons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/themes/frontend/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/themes/frontend/icons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/themes/frontend/icons/favicon-16x16.png">
        <link rel="manifest" href="/themes/frontend/icons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/themes/frontend/icons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <?php $this->head() ?>
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="sidebar_main_open sidebar_main_swipe">
    <?php $this->beginBody() ?>
    <!-- start: HEADER -->
        <?=$content?>
        
    <?php $this->endBody() ?>
    </body>
    <!-- end: BODY -->
    </html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>