<?php
\app\assets\CoreAssets::register($this);
//\app\assets\KasbAsset::register($this);
$this->title=Uni::t('app','Давлат ветеринария қўмитаси');
use \uni\helpers\Html;
 $this->beginPage() ?>
<?\app\components\widgets\Compressor::begin()?>
<!DOCTYPE html>
<html lang="<?= Uni::$app->language ?>" class="no-js">
<head>
    <title><?=Html::encode($this->title) ?></title>
    <meta charset="<?= Uni::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->

    <?php $this->head() ?>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/theme/admin/plugins/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<!--    alert-cursor-182322-->
    <style>
        .login_page{
            background-image: url("/themes/images/login.jpg");
            background-attachment: scroll;
            background-size: cover;
            background-position: center center;
        }
        .form-header{
            padding: 10px;;
        }
        .b{
            border: 1px solid darkgrey;
        }
        .radio-inline{
            margin-left: 0 !important;
            margin-left: 0 !important;
            padding: 8px 10px; border: 1px solid darkgrey; background-color: #fff;
            border-radius: 2px;
            box-decoration-break: slice;
        }
        .radio-group input{
            visibility: hidden;
        }
        .radio-group{
            padding: 10px 10px;
            /*border: 1px solid darkgrey;*/
            /*border-radius: 10px;*/
        }
    </style>
</head>
<body style="overflow:hidden" class="login_page">
<?php $this->beginBody() ?>
<div class="clearfix">
    <?=$content?>
</div>

<?php $this->endBody() ?>
</body>
<!-- end: BODY -->
</html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>