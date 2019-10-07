<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Url;
use app\models\Lang;

$this->title = Lang::t('Error');
$this->params['desc']=$this->title;
$this->params['img'] = 'themes/edutech/images/404.png';
?>
<!-- Page Breadcrum __________________________ -->
<div class="page-breadcrum">
    <div class="container">
        <ul>
            <li><a href="<?=Url::to('/')?>"><?=Lang::t('Home')?></a></li>
            <li>-</li>
            <li><?=$this->title?></li>
        </ul>
    </div> <!-- /.container -->
</div> <!-- /.page-breadcrum -->


<!-- Error Page _________________________ -->
<div class="error-page">
    <div class="container">
        <div class="error-wrapper clear-fix">
            <img src="/themes/edutech/images/404.png" alt="" width="60%" class="float-left wow fadeInLeft">
            <div class="text float-right wow fadeInRight">
                <h2>404 <span class="p-color opps">opps!</span> <span class="last p-color">ERROR!</span></h2>
                <p><?=Lang::t('The page you are looking for does not exist')?>.</p>
                <a href="<?=Url::to('/')?>" class="tran3s"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?=Lang::t('Back')?></a>
            </div> <!-- /.text -->
        </div> <!-- /.error-wrapper -->
    </div> <!-- /.container -->
</div> <!-- /.error-page -->

