<?
use uni\ui\Form;
use app\models\UserModel;

$model = new UserModel();
$role=1;
if(isset($_GET['user'])){
    $role=$_GET['user'];
}
$this->registerCss('
.radio-active{
    background:$0f0;
    }

');

?>

<div class="container " style="padding: 120px;    ">
    <div class="col-md-12 " style="padding: 10px;" >
        <div class="col-md-6 b"style="background-color: rgba(97, 185, 252, 0.61);padding: 90px;height: 520px;" >
           <div class="for-learner">
               <h1 style="color: #fff;"1> O'zbekistonda onlayn kasb o'rganish tizimi.</h1>

                 <h2 style="color: #fff;">  Ushbu Video Portal yordamida har bir foydalanuvchi o'zi uchun kerakli va qiziqarli bo'lgan kasblar bo'yicha barcha nazariy va amaliy ko'nikmalarga ega bo'ladi.</h2>
           </div>
            <div class="for-teacher" >
               <h1 style="color: #fff;">O'zbekistonda onlayn kasb o'rganish tizimi.</h1>
                <h2 style="color: #fff;">  Ushbu Video Portal yordamida har bir foydalanuvchi o'zi uchun kerakli va qiziqarli bo'lgan kasblar bo'yicha barcha nazariy va amaliy ko'nikmalarga ega bo'ladi.

                    </h2>
           </div>
            <div class="for-parent" >
               <h1 style="color: #fff;"> O'zbekistonda onlayn kasb o'rganish tizimi.</h1>
                  <h2 style="color: #fff;"> Portal yordamida har bir foydalanuvchi o'zi uchun kerakli va qiziqarli bo'lgan kasblar bo'yicha barcha nazariy va amaliy ko'nikmalarga ega bo'ladi.</h2>
           </div>
        </div>
        <div class="col-md-6 b" style="background-color: #fff;height: 520px;padding: 8px 15px;">
            <div class="group">
                <div class="col-md-12 " style="margin: 10px;;">
                    <div class="col-md-12">
                        <h3>Ijtimoiy saytlar yordamida registratsiydan o'tish</h3>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-social-icon btn-facebook" style="background-color: #3B5998;color: White;margin-left: 25px;">
                            <span class="fa fa-facebook"></span> Facebook
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-social-icon btn-google" style="background-color: #DD4B39;color: white;margin-left: 18px;">
                            <span class="fa fa-google"></span> Google
                        </a>
                    </div>
                </div>
            </div>

            <div class="form-content col-md-12 " >
                <?php $form = Form::begin(['action'=>'/users/auth/register']); ?>
                <div class="radio-group col-md-12 text-center" style="margin: 10px;">
                    <label class="radio-inline 1a col-md-6" style=" <?=($_GET['user'] == 0) ? 'background: #449d44;' : ''?>" ><input type="radio"  id="for-learner" value="0"  name="learner" >O'quvchi</label>
                    <label class="radio-inline 2a col-md-6" style="<?=($_GET['user'] == 1) ? 'background: #3071a9;' : ''?>"><input type="radio" id="for-teacher" value="1"  name="teacher">O'qituvchi</label>
                </div>
                <br style="clear: both"/>
                <?= $form->field($model, 'username',['template'=>'<div class="form-group"><label for="username"> {label}</label>{input}</div>'])->textInput() ?>

                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'password')->passwordInput(['id' => 'pwd_one']) ?>
                <?= $form->field($model, 'role')->hiddenInput(['id' => 'user_role','value'=> $_GET['user']])->label(false) ?>
                    <button type="submit" id="click-me" class="btn <?=($_GET['user'] == 0) ? 'btn-success' : 'btn-primary'?> btn-block ">Ro'yhatdan o'tish</button>
                <?php Form::end(); ?>
                <a href="login" style="text-align: center;color#fff;">Ro'yhatdan o'tganmisiz?</a>
            </div>
        </div>
    </div>
</div>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.10&appId=135147097214191";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
<?
$this->registerJs('
    $(document).ready(function(){
    $(".for-teacher").hide();
    $(".for-parent").hide();
        $("#for-learner").click(function(){
            $("#user_role").val("0");
            $("#click-me").removeClass("btn-primary");
            $("#click-me").addClass("btn-success");
            $(".1a").css("background","#449d44");
            $(".2a").css("background","#fff");
            $(".for-learner").fadeIn("slow");
            $(".for-teacher").hide("slow");
            $(".for-parent").hide("slow");
        });
         $("#for-teacher").click(function(){
            $("#user_role").val("1");
             $("#click-me").removeClass("btn-success");
             $("#click-me").addClass("btn-primary");
              $(".2a").css("background","#3071a9");
            $(".1a").css("background","#fff");
            $(".for-teacher").fadeIn("slow");
            $(".for-learner").hide("slow");
            $(".for-parent").hide("slow");
        });
       
    });
');
?>