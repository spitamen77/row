<?
\app\assets\ErrorAssets::register($this);
$this->title=Uni::t('app','You can learn anything');
use \uni\helpers\Html;
use app\components\manager\Url;
$block=Uni::$app->controller->block;

$this->registerJs(' Muxr.stay_idle();');
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
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="Nuriddin" />
        <?php $this->head() ?>
        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
<!--        <link rel="shortcut icon" href="/favicon.ico" />-->
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="error_page">
    <?php $this->beginBody() ?>
        <?=$content?>
    <?php $this->endBody() ?>
    </body>
    <!-- end: BODY -->
    </html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>