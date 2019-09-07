<body class="lock-screen">
<?php $form = \uni\ui\Form::begin([
    'id' => 'login-form',
    'options' => ['class' => 'no-margin'],
]); ?>
<div class="main-ls  col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
    <div class="logo">
        Edoc<i class="clip-clip"></i>uz
    </div>
    <div class="box-login">
        <div class="text-center">
            <img alt=""  class="center clip-image" src="http://erp.loc/filemanager/uploads/?module=hr&folder=avatars&file=<?=Uni::$app->user->identity->info->personal_picture?>&mode=lock">
        </div>
    <div class="user-info">
        <h1><i class="fa fa-lock"></i> <?=Uni::$app->user->identity->makeFIO()?></h1>
        <span><?=Uni::$app->user->identity->info->email?></span>
        <span><em><?=Uni::t('app','Please enter the unlock password.')?></em></span>
        <form action="" method="POST">
                <input type="hidden" name="LoginForm['login']" value="<?=Uni::$app->user->identity->login?>"/>
                <?= $form->field($model, 'password', ['template'=>"\n<div class=\"input-group\">{input}\n<span class=\"input-group-btn\"><button class=\"btn btn-blue\" type=\"submit\"><i class=\"fa fa-chevron-right\"></i>
                                </button> </span></div>\n{hint}\n{error}"])->passwordInput(["placeholder"=>'<?=Uni::t(\'app\',\'enter the password to log in\')?>'])?>
            <div class="relogin">
                <a href="/logout">
                    Не <?=Uni::$app->user->identity->makeFIO()?></a>
            </div>
        </form>
    </div>
</div>
    <div class="copyright">
       <?=Uni::t('app',' 2015 &copy; Muxr.uz by Rashidov Nuriddin.')?>
    </div>
</div>
<?php \uni\ui\Form::end(); ?>
