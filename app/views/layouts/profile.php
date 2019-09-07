<?
\app\assets\KasbAsset::register($this);
$this->title=Uni::t('app','You can learn anything');
use \uni\helpers\Html;
use app\components\manager\Url;
$block=Uni::$app->controller->block;
?>
<?php $this->beginPage() ?>
<?\app\components\widgets\Compressor::begin()?>
<!DOCTYPE html>
<html  lang="<?= Uni::$app->language ?>" >

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=Html::encode($this->title) ?></title>
    <!-- start: META -->
    <meta charset="<?= Uni::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    
    
    <title>KASB.UZ | Bosh sahifa </title>
    <?php $this->head() ?>
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>

<body class="home page-template-default page page-id-572">

<?php $this->beginBody() ?>

<!-- WRAPPER -->
<div id="wrapper">
    <div id="main-content">
        <?= Uni::$app->controller->renderPartial("@app/views/profile/header") ?>
        <?= $content ?>
        <?= Uni::$app->controller->renderPartial("@app/views/kasb/footer") ?>

    </div>
</div>
<?php $this->endBody() ?>


</body>

</html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>