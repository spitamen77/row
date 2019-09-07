<?
use uni\ui\Form;
use uni \helpers\Url;
$user=new \app\models\UserModel();
$this->registerCssFile("/themes/ui/assets/css/login_page.min.css");
$this->registerJsFile ("/themes/ui/assets/js/pages/login.min.js",['depends' => ['app\assets\CoreAssets']]);
$this->registerJsFile ("/themes/ui/components/jquery.inputmask/dist/jquery.inputmask.bundle.js",['depends' => ['app\assets\CoreAssets']]);
$this->registerJs('Muxr.masked_inputs();Muxr.char_words_counter();Muxr.register();');

?>
<div class="login_page_wrapper" style="width: 400px;padding-bottom: 8px !important; ">
    <div class="md-card uk-animation-15" id="login_card" style="min-height: 100%">
        <div class="md-card-content large-padding" id="login_form">
            <div class="login_heading" style="margin-bottom: 20px !important;">
                <div class="user_avatar"></div>
            </div>

            <?php $form = Form::begin([
                'id' => 'login-form',
                'options' => ['class' => 'no-margin']
            ]); ?>
            <? if($model->userblock){ echo $form->field($model,'userblock',['template'=>"<span class=' help-block center-block alert alert-danger'>{error}</span>"]); }?>

            <?= $form->field($model, 'email',['template' => "\n<div class=\"uk-form-row\"><label for=\"login_username\">{label}</label>
                    {input} </div> \n<div class=\"help-block\">{error}</div>"])->textInput() ?>
            <br/>
            <?= $form->field($model, 'password',['template' => "\n<div class=\"uk-form-row\"><label for=\"login_password\">{label}</label>{input}
                        <a href='#' class='password_reset_show' >".Uni::t("app","I forgot my password")."</a>
                    </div>\n<div class=\"help-block\">{error}</div>"])->passwordInput() ?>

            <div class="uk-margin-medium-top">
                <button class="md-btn md-btn-warning md-btn-block md-btn-large" type="submit"><?=Uni::t("app","Login")?></button>
            </div>
            <div class="uk-grid uk-grid-width-1-3 uk-grid-small uk-margin-top">
                <?=Uni::t("app","Number of wrong attempts is limited")?>
                <br/>
                <?=Uni::t("app","info")?>
            </div>
            <div class="uk-margin-top">
                <a href="#" id="login_help_show" class="uk-float-right">Нужна помощь?</a>
                <span class="icheck-inline">
                            <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck="">
                            <label for="login_page_stay_signed" class="inline-label">Оставаться в системе</label>
                        </span>
            </div>
            <?php Form::end(); ?>
<!--            <div class="uk-margin-top uk-text-center">-->
<!--                <a href="--><?//=Url::to(['/users/auth/join','user' =>1])?><!--">--><?//=Uni::t('app','Create an account')?><!--</a>-->
<!--            </div>-->
        </div>
        <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
            <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
            <h2 class="heading_b uk-text-success"><?=Uni::t('app', 'Can\'t log in')?>?</h2>
            <p><?=Uni::t('app', 'Here’s the info to get you back in to your account as quickly as possible')?>.</p>
            <p><?=Uni::t('app', 'First, try the easiest thing: if you remember your password but it isn’t working, make sure that Caps Lock is turned off, and that your username is spelled correctly, and then try again')?>.</p>
            <p><?=Uni::t('app', 'If your password still isn’t working, it’s time to')?> <a href="#" class='password_reset_show' ><?=Uni::t('app', 'reset your password')?></a> <?=Uni::t('app', 'or call the number')?> +998(71) - 202-1200.</p>
        </div>


        <div class="md-card-content large-padding login-box" id="login_password_reset" style="display: none">
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
                    <a class="login-frm-button margin-tp back_to_login" href="#"><?=Uni::t('app', 'Login')?></a>
                </p>
                <p class="status">
                </p>

<!--                <input type="hidden" id="security3" name="security3" value="6f14922599">-->
<!--                <input type="hidden" name="_wp_http_referer" value="/mytube/">-->
            </form>
        </div>
        <div class="md-card-content large-padding" id="activate" style="display: none">
            <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
            <h2 class="heading_a uk-margin-large-bottom">Activation</h2>
            <h3>Account successfully created</h3>
            <p>
                We are send sms to your phone. Please insert received code
            </p>
            <form class="form-forgot" novalidate="novalidate">
                <fieldset>
                    <div class="uk-form-row">
                           <span class="input-icon">
                            <input type="number" class="md-input" name="activation" id="activeNumber" placeholder="Code">
                        </span>
                    </div>
                    <input type="hidden" name="pk" id="regUserId">
                    <br/>
                    <div class="uk-form-row">
                        <a  class="md-btn md-btn-flat md-btn-flat-primary back_to_login">
                            назад
                        </a>
                        <button style="float: left" type="button" id="sendActivationCode" class="md-btn md-btn-success pull-right">
                            Отправить
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>


    </div>

</div>


