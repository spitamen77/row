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