<?
\app\assets\KasbAsset::register($this);
$user=new \app\models\UserModel();
$this->title=Uni::t('app','You can learn anything');
$model=new \app\models\forms\LoginForm();
use \uni\helpers\Html;
use app\components\manager\Url;
$block=Uni::$app->controller->block;
$this->registerJs('Muxr.register();');

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

<body class="home page-template-default page page-id-572" >

<?php $this->beginBody() ?>
<script type="text/javascript">

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

function statusChangeCallback(response) {
        console.log('statusChangeCallback bajarildi');
        console.log(response);
       
        if (response.status === 'connected') {
            console.log("ma'lumotlar keldi");
           console.log(response);
            testAPI();
        } else {
            document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
                window.location.reload();
        }
    }
    

 window.fbAsyncInit = function() {
            FB.init({
                appId      : '338497183276135',
                status     : true,
                cookie     : true,
                xfbml      : true,
                version    : 'v2.8'
            });
        };

    function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me?fields=id,last_name,first_name,email', function(response) {
         console.log(response.last_name);
         console.log(response.first_name);
         console.log(response.email);
          
          $.post("/page/course/facebookuser",{username:response.first_name,password:response.id,email:response.email,last_name:response.last_name},
                  function(response){
                console.log('Successful response getted : ');
            },
            
        );

    })
}
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- WRAPPER -->
<div id="wrapper">
    <div id="main-content">

        

        <?= Uni::$app->controller->renderPartial("@app/views/kasb/header") ?>
        <?= $content ?>
        <?= Uni::$app->controller->renderPartial("@app/views/kasb/footer") ?>

    </div>
    <!-- sign up form start -->
    <div id="login-box">
  

        <i class="fa fa-remove login-toggle"></i>
        <!-- Login from -->

        <?php $form = \uni\ui\Form::begin([
            'id' => 'login-form',
            'action'=>'/users/auth/login',
            'options' => ['class' => 'user-form login-form form-active text-center']
        ]); ?>
        <? if($model->userblock){ echo $form->field($model,'userblock',['template'=>"<span class=' help-block center-block alert alert-danger'>{error}</span>"]); }?>

        <?= $form->field($model, 'email',['template' => "\n<div class=\"form-group\"><label for=\"login_username\">{label}</label>
                    {input} </div> \n<div class=\"help-block\">{error}</div>"])->textInput() ?>

        <?= $form->field($model, 'password',['template' => "\n<div class=\"form-group\"><label for=\"login_password\"> {label} </label>{input}
                    </div>\n<div class=\"help-block\">{error}</div>"])->passwordInput(['class'=>'form-control']) ?>

        <div class="form-group">
            <button class="btn btn-success btn-block md-btn-large" type="submit"><?=Uni::t("app","Login")?></button>
        </div>
        <div class="col-md-12">
            <h5>
                <?=Uni::t("app","Number of wrong attempts is limited")?>
            </h5>

        </div>
        <div class="form-group">
            <a href="#" id="login_help_show" class="pull-right">Yordam kerakmi?</a><br>
            <span class="icheck-inline">
                            <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" >
                            <label for="login_page_stay_signed" class="inline-label">Tizimda qolish</label>
                        </span>
        </div>
        <?php \uni\ui\Form::end(); ?>

    </div>
    <!-- sign up form end -->

</div>
<?php $this->endBody() ?>


</body>

</html>
<?php $this->endPage() ?>
<?\app\components\widgets\Compressor::end()?>