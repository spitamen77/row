<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use uni\db\Query;
use app\models\Speciality;
use app\models\SubjectCategory;
use app\models\Subject;
use app\models\Course;
use app\models\UserModel;
\app\components\widgets\SweetAlertAsset::register($this);


$speciality = Speciality::find()->where(['status'=>1])->all();
$subcat = SubjectCategory::find()->where(['status'=>1])->all();
$countSubject = Subject::find()->where(['status'=>1])->count();
$countCourse = Course::find()->where(['status'=>1])->count();
$countStudent = (new Query())->select('COUNT(*) as n')->from('uni_groups_users as u')->leftJoin('uni_groups as g', 'u.group_id = g.id')->where(['g.groupp'=>'STD'])->count();
$countTeacher = (new Query())->select('COUNT(*) as n')->from('uni_groups_users as u')->leftJoin('uni_groups as g', 'u.group_id = g.id')->where(['g.groupp'=>'TECH'])->count();
// echo $countSubject."-";
// echo $countStudent."-";
// echo $countCourse;exit;

?>
<!-- ====SLIDER START==== --> 
        <section class="slider_area">
            <div class="slider_left_bg">
                <div class="container">
                    <br>
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="hero-content">
                                    <h1><br><span>Kasb-hunar.</span>uz</h1>
                                    <p> Onlayn kasb o'rganish milliy tizimi. Endi barchasi oson va tez.</p> 
                                    <a href="<?=Url::to('users/auth/join?user=0')?>" class="btn-action white"><?=Uni::t('app','O\'quvchi')?></a> 
                                    <a href="<?=Url::to('users/auth/join?user=1')?>" class="btn-action white"><?=Uni::t('app','O\'qituvchi')?></a>
                                    <a href="<?=Url::to('users/auth/login')?>" class="btn-action white"><?=Uni::t('app','Admin')?></a> 
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="banner-img">
                                    <img src="/themes/kasb/img/banner-img.png" alt="" class="img-responsive center-block">
                                </div>
                            </div>
                        </div>
                       <br class="clearfix"/>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====SLIDER END==== -->
        
        <!-- ====FEATURE AERE==== --> 
        <section class="feature_area" id="services">
            <div class="container">
                <div class="row fix_m">
                    <? foreach ($subcat as $val) {?>
                    <div class="col-xs-12 col-sm-6 col-md-3 fix_p">
                        <div class="single_feature text-center">
                            <i class="zmdi"><img src="/themes/images/Umumtalim.png" width="23"></i>
                            <h4><?=$val->title?></h4>
                            <div class="single_cap">
                            <p>Elektron video darsliklarni ulashing va ta'lim tizmini isloh qiling.</p>
                            <a class="th_bt btn waves-effect" href="<?=$this::to('page/subject/view/').$val->id?>">Batafsil</a>
                            </div>
                        </div>   
                    </div>
                    <?}?>
                    
                    
                    
                </div>
            </div>
        </section>
        <!-- ====FEATURE AERE END==== -->
        
        <!-- ====ABOUT US==== -->
        <section id="about" class="about_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="about_left">
                            <img src="/themes/extra/img/about_left.png" alt=""/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="section_title">
                            <h5 class="smallHd">Video Portal</h5>
                            <h2 class="secHd">Ushbu tizim xaqida</h2>
                        </div>
                        <div class="about_text">
                            <p>UNESCO ning O'zbekistondagi vakolatxonasi hamda O'rta maxsus, kasb-hunar ta'limi markazi bilan hamkorlikda tayyorlangan ushbu ta'lim portali kasb-hunar ta'limini o'rgatishda mustaqil ta'lim olish uchun xizmat qiladi.</p>
                           <p class="ab_text">Portal yordamida har bir foydalanuvchi o'zi uchun kerakli va qiziqarli bo'lgan kasblar bo'yicha barcha nazariy va amaliy ko'nikmalarga ega bo'ladi.</p>
                            <a class="th_bt btn waves-effect waves-light" href="#!">Batafsil</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====ABOUT US==== -->
        
        <!-- ====START PROJECT AREA==== -->
        <section class="project_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="single_fact text-center">
                            <div class="fact_icon">
                                <div class="RXcircleEffect"></div>
                                <i class="zmdi">
                                    <img src="/themes/images/4/Barcha-darsliklar.png" width="57">
                                </i>
                            </div>
                            <h2><span class="counter"><?=$countSubject?></span>+</h2>
                            <p>Barcha dasrliklar</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="single_fact text-center">
                            <div class="fact_icon">
                                <div class="RXcircleEffect"></div>
                                <i class="zmdi">
                                    <img src="/themes/images/4/Foydalanuvchi.png" width="57">
                                </i>
                            </div>
                            <h2><span class="counter"><?=$countStudent?></span>+</h2>
                            <p>Foydalanuvchilar</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="single_fact text-center">
                            <div class="fact_icon">
                                <div class="RXcircleEffect"></div>
                                <i class="zmdi">
                                    <img src="/themes/images/4/Hamkor.png" width="57">
                                </i>
                            </div>
                            <h2><span class="counter"><?=$countCourse?></span>+</h2>
                            <p>Kurslar</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="single_fact text-center">
                            <div class="fact_icon">
                                <div class="RXcircleEffect"></div>
                                <i class="zmdi">
                                    <img src="/themes/images/4/Uqituvchi.png" width="57">
                                </i>
                            </div>
                            <h2><span class="counter"><?=$countTeacher?></span></h2>
                            <p>O'qituvchilar</p>
                        </div>
                    </div>
                </div>
            </div> 
        </section>
        <!-- ====END START PROJECT AREA==== -->
        
        <!-- ====PROTFOLIO AREA==== -->
        <section id="Portfolio" class="protfolio_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section_title mb80">
                            <h5 class="smallHd text-center">UMUMIY</h5>
                            <h2 class="secHd text-center">FANLAR</h2>
                        </div>
                    </div>                                                
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="work_trigge">
                            <ul class="trigger mb80 text-center">
                                <li class="filter active" data-filter="">Barchasi</li>
                                <li class="filter" data-filter=".html">Umumtalim</li>
                                <li class="filter" data-filter=".wordpress">Umumkasbiy</li>
                                <li class="filter" data-filter=".ui_ux">Maxsus</li>
                                <li class="filter" data-filter=".print">Amaliy</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="all_work_item">
                        <div class="col-xs-12 col-sm-6 col-md-4 mix all ui_ux">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup1.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup1.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>Umumta'lim</h4>
                                        <p>Fizika/ Mexanika</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 mix all wordpress print">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup3.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup3.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>Informatika</h4>
                                        <p>Dasturlash / Algoritmlar</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 mix all wordpress html">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup6.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup6.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>Matematika</h4>
                                        <p>Trigonomeriya</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 mix print">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup4.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup4.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>Umumkasbiy</h4>
                                        <p>Arxitektura/Qurulish</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 mix all ui_ux">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup2.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup2.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>Maxsus</h4>
                                        <p>Qishloq/Agronom</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 mix html">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup7.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup7.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>Marketing</h4>
                                        <p>Onlayn Marketing</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 mix wordpress">
                            <figure>
                                <div class="RXcircleEffect"></div>
                                <img src="/themes/extra/img/mixtup5.jpg" alt="" />
                                <figcaption>
                                    <div class="capCont">
                                        <ul class="iconlink">
                                            <li>
                                                <a data-gall="group_1" class="veno vbox-item" href="/themes/extra/img/mixtup5.jpg">
                                                    <i class="zmdi zmdi-zoom-in btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-link btn btn-link btn waves-effect waves-dark"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <h4>O'quv amaliyot</h4>
                                        <p>Texnologiya/ Dizayner</p>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>                                                
                </div>
                <div class="row">
                    <div class="col-xs-12 trigger_bottom">
                        <a href="#!" class="th_bt btn waves-effect waves-light">Barchasi
                            <i class="zmdi zmdi-long-arrow-right"></i>
                        </a> 
                    </div>
                </div>
            </div>    
        </section>
        <!-- ====END PROTFOLIO AREA==== -->
        
        <!-- ====START WHY CHOOSE==== -->
        <section class="whychoose">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section_title mb80">
                            <h5 class="smallHd text-center">Bizning </h5>
                            <h2 class="secHd text-center">Sohalar & Fanlar</h2>
                        </div>
                    </div>                                                
                </div>
                <div class="row checkBGFull">
                    <div class="col-xs-12 col-sm-6 ourFeaturesContent section-padding">
                        <div class="single_checkCont">
                            <a href="<?=$this->to('page/speciality/list/1')?>">
                            <div class="checkIcon">
                                <img src="/themes/images/Gumanitar.png" style="width: 70px;">
                            </div>
                            <div class="checkText">
                                <h4>Gumanitar soha</h4>
                                <p>Pedagogika, gumanitar fanlar, tabiiy fanlar, san'at. </p>  
                            </div>
                            </a>
                        </div>
                        <div class="single_checkCont">
                            <a href="<?=$this->to('page/speciality/list/12')?>">
                            <div class="checkIcon">
                                <img src="/themes/images/Ijtimoiy.png" style="width: 70px;">
                            </div>
                            <div class="checkText">
                                <h4>Ijtimoiy soha, Iqtisod va huquq</h4>
                                <p>Jurnalistika va axborot, iqtisod, huquq. </p>  
                            </div>
                        </a>
                        </div>
                        <div class="single_checkCont">
                            <a href="<?=$this->to('page/speciality/list/13')?>">
                            <div class="checkIcon">
                                <img src="/themes/images/IshlabCh.png" style="width: 70px;">
                            </div>
                            <div class="checkText">
                                <h4>Ishlab chiqarish va taxnika soha </h4>
                                <p>Muhandislik ishi, ishlab chiqarish, axborot texnologiyalar, arxitektura, kammunikasiya texnologiyalar. </p>  
                            </div>
                        </a>
                        </div>   
                    </div>
                    <div class="checkfeature_contbg hidden-xs" style="background-image: url(/themes/extra/img/feature_post_img_1.jpg);"></div>
                </div>
                <div class="row checkBGFull">
                    <div class="col-xs-12 col-sm-6 ourFeaturesContent section-padding">
                        <div class="single_checkCont">
                            <a href="<?=$this->to('page/speciality/list/14')?>">
                            <div class="checkIcon">
                                 <img src="/themes/images/QX.png" style="width: 70px;">
                            </div>
                            <div class="checkText">
                                <h4>Qishloq va suv xo'jaligi</h4>
                                <p>Qishloq, o'rmon va baliq xo'jaligi, fermer xo'jaligini boshqarish, veterenariya. </p>  
                            </div>
                        </a>
                        </div>
                        <div class="single_checkCont">
                            <a href="<?=$this->to('page/speciality/list/15')?>">
                            <div class="checkIcon">
                                <img src="/themes/images/Tibbiyot.png" style="width: 70px;">
                            </div>
                            <div class="checkText">
                                <h4>Sog'liqni saqlash va ijtimoiy taminot</h4>
                                <p>Sog'liqni saqlash, ijtimoit taminot. </p>  
                            </div>
                        </a>
                        </div>
                        <div class="single_checkCont">
                            <a href="<?=$this->to('page/speciality/list/16')?>">
                            <div class="checkIcon">
                                <img src="/themes/images/Xizmatlar.png" style="width: 70px;">
                            </div>
                            <div class="checkText">
                                <h4>Xizmatlar sohasi</h4>
                                <p>Xizmat ko'rsatish sohasi, transport, atrof muhit muhofazasi. </p>  
                            </div>
                        </a>
                        </div>   
                    </div>
                    <div class="checkfeature_contbg hidden-xs" >
                        <img src="/themes/extra/img/feature_post_img_2.jpg" style="height: 635px;">
                    </div>
                </div>
            </div>
        </section>
        <!-- ====END WHY CHOOSE==== -->
        
        <!-- ====START SERVICE AREA==== -->
        <section class="service_area section-padding">
            <div class="container">
            </div>
        </section>
        <!-- ====END SERVICE AREA==== -->
        
        <!-- ====START SOCIAL LINK==== -->
        <section class="social_btn">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-8">
                        <h3>Video portal Unesco bilan hamkorlikda amalga oshirildi</h3>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <a class="th_bt btn waves-effect waves-light" href="http://www.unesco.org/new/en/tashkent/">UNESCO
                            <i class="zmdi zmdi-long-arrow-right"></i>
                        </a>    
                    </div>
                </div>
            </div>
        </section>
        <!-- ====END SOCIAL LINK==== -->
        
        
        
        <!-- ====START CONTACT AREA==== -->
        <section id="contact" class="map-area">
            <div class="contact_google_map">
                <div id="contactgoogleMap"></div>
            </div>
            <div class="contact-area">
                <div class="container">
                    <div class="contact_text col-md-6">
                        <div class="section_title">
                            <h2 class="text-left">Bog'lanish</h2>
                            <p>Bizga bog'laning va savollarni bering</p>
                        </div>
                        <form action="" method="post">
                            <div class="row jsSubmit_button">
                                <div class="input-field col-md-6">
                                    <input id="contact_name" type="text" class="validate" name="your_name" required>
                                    <label for="contact_name">
                                        <i class="zmdi zmdi-account"></i>F.I.SH.
                                        <span>*</span>
                                    </label>
                                </div>
                                <div class="input-field col-md-6">
                                    <input id="contact_email" type="email" class="validate" name="your_mail" required>
                                        <label for="contact_email"><i class="zmdi zmdi-email"></i>Email
                                        <span>*</span>
                                    </label>
                                </div>
                                <div class="input-field col-md-12">
                                    <textarea id="textarea1" name="your_text" class="materialize-textarea" required></textarea>
                                    <label for="textarea1"><i class="zmdi zmdi-border-color"></i>Xabar
                                        <span>*</span>
                                    </label>
                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="th_bt btn waves-effect" name="submit_btn">
                                        Jo'natish<i class="zmdi zmdi-mail-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </section>
        <!-- ====END CONTACT==== -->