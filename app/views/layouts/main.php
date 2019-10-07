<?
\app\assets\AdminAssets::register($this);
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
    <html lang="<?= Uni::$app->language ?>">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title><?=Html::encode($this->title) ?></title>
        <!-- start: META -->
        <meta charset="<?= Uni::$app->charset ?>"/>
        <?= Html::csrfMetaTags() ?>
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="icon" href="/themes/joli/favicon.ico" type="image/x-icon" />
        <link rel="apple-touch-icon" sizes="180x180" href="/themes/joli/favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="/themes/joli/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/themes/joli/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta name="author" content="http://www.websar.uz">

        <!-- Og:type -->
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="<?=Uni::t('app','Training center Outcome Tree')?>">
        <meta property="og:title" content="<?= Html::encode($this->title) ?>">
        <meta property="og:description" content="<?=$this->params['desc']?>">
        <meta property="og:url" content="http://www.outcometree.uz<?=Uni::$app->request->url?>">
        <meta property="og:locale" content="<?= Uni::$app->language ?>">
        <meta property="og:image" content="<?=($this->params['img'])?'http://www.outcometree.uz/web/'.$this->params['img']:'http://www.outcometree.uz/web/themes/edutech/images/logo3.png'?>">
        <meta property="og:image:width" content="968">
        <meta property="og:image:height" content="504">
        <!-- Page Description and Author -->
        <meta name="description" content="<?=$this->params['desc']?>">
        <meta name="author" content="http://www.websar.uz">

        <?php $this->head() ?>
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body>
    <?php $this->beginBody() ?>
    <!-- start: HEADER -->
    <?=Uni::$app->controller->renderPartial("//layouts/header")?>
    <?= $content ?>
    <?=Uni::$app->controller->renderPartial("//layouts/footer")?>
    <!-- START PRELOADS -->
    <audio id="audio-alert" src="/themes/joli/audio/alert.mp3" preload="auto"></audio>
    <audio id="audio-fail" src="/themes/joli/audio/fail.mp3" preload="auto"></audio>
    <!-- END PRELOADS -->
    <?php $this->endBody() ?>
    </body>
    <!-- end: BODY -->
    </html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>