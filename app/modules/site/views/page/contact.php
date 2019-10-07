<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\Lang;
use yii\helpers\Url;

$this->title = Lang::t('Contact us');
$this->params['breadcrumbs'][] = $this->title;
$this->params['desc']=$this->title;
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


            <!-- Contact Us Form _____________________ -->
            <div class="contact-us-page">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 wow fadeInLeft">
                            <div class="contact-us-form">
                                <h1 style="font-size: 30px"><?= Html::encode($this->title) ?></h1>

                                <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                                    <div class="alert alert-success">
                                        <?=Lang::t('Thank you for contacting us. We will respond to you as soon as possible')?>.
                                    </div>

                                    <p>
                                        
                                    </p>

                                <?php else: ?>
                                <!-- <h3>Send A Message</h3> -->
                                <p><?=Lang::t('Your email address will not be published')?>.</p>
                                <?php $form = ActiveForm::begin(['class'=>'form-validation']); ?>
                                <!-- <form action="inc/sendemail.php" class="form-validation" autocomplete="off"> -->
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'name')->textInput(['autofocus' => true])->input('text', ['placeholder' => Lang::t("Name")])->label(false) ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <?= $form->field($model, 'email')->input('email', ['placeholder' => "Email"])->label(false) ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'subject')->input('text', ['placeholder' => Lang::t("Theme")])->label(false) ?>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'body')->textarea(['rows' => 6])->label(false) ?>
                        
                                        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                            'template' => '<div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div>',
                                        ])->label(false) ?>
                                            <button class="tran3s p-color-bg themehover" title="Send"><?=Lang::t('Send')?></button>
                                        </div>
                                    </div>
                                <?php ActiveForm::end(); ?>
                                <?php endif;?>
                               
                            </div> <!-- /.contact-us-form -->
                        </div> <!-- /.col- -->

                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 wow fadeInRight">
                            <div class="contactUs-address">
                                <h3><?=$this->title?></h3>
                                <p><?=Lang::t('Welcome to our website , Feel free to contact us any time')?> </p>

                                <ul>
                                    <li>
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <a href="mailto:<?=Lang::t('emailto')?>" class="tran3s"><?=Lang::t('emailto')?></a>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <a href="tel:<?=Lang::t('telefon')?>" class="tran3s"><?=Lang::t('telefon')?></a>
                                    </li>
                                    <li><i class="fa fa-map-marker" aria-hidden="true"></i><?=Lang::t('Address')?></li>
                                </ul>

                            </div> <!-- /.our-address -->
                        </div>
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /.contact-us-page -->


            <!-- Google Map -->
            <div id="google-map" style="height:460px; width:100%; margin-top:100px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d2119.4170772478055!2d69.23463636761767!3d41.30215463895806!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sus!4v1568797357431!5m2!1sru!2su" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>

            </div>
