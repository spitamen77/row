<?
use app\components\manager\Url;
$this->registerCssFile("/includes/bootstrap-fileupload/bootstrap-fileupload.min.css");
$this->registerCssFile("/includes/bootstrap-social-buttons/social-buttons-3.css");
$this->registerJsFile("/includes/bootstrap-fileupload/bootstrap-fileupload.min.js",['depends' => [
    'app\assets\HrAssets']]);
$this->registerJs("$(document).on('click','#add-todo',function(){
$('#add-todo-modal').modal('show');
});
$(document).on('click','#todosavebtn',function(){
var task=$('#tasktext').val();
var tasktype=$('#tasktype').val();
$.post('/todo/default/add',{task:task,tasktype:tasktype,_csrf:'".Yii::$app->request->getCsrfToken()."'},function(data){
$('#resulttodo').html(data);
$('#resulttodo').show();
});
});
$('#photo-image').change(function(){
$('#profile-form').submit();
});
");
$this->registerJs("$(\"#updatepass\").click(function(){
var passw=$(\"input[name='password']\").val();
      var repass=$(\"input[name='repassword']\").val();
      if(passw==repass){
        var userid=$(\"#userid\").val();
        $.post(\"".$this->to("hr/employee/changepass")."\",{pass:passw,user:userid},function(data){
            if(data=='success'){
            $(\"#successmes\").fadeOut();
            $(\"#successmes\").html('Пароль пользователя обновлена : '+passw);
              $(\"#notvalidretype\").fadeOut();
            $(\"#successmes\").fadeIn();}else{
            $(\"#successmes\").fadeOut();
               $(\"#notvalidretype\").fadeOut();
             $(\"#notvalidretype\").html(data);
            $(\"#notvalidretype\").fadeIn();
            }
        });
      }else{
            $(\"#notvalidretype\").fadeIn();
            }
    });",4);
?>
<div class="row">
<div class="col-sm-12">
<div class="tabbable">
<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
    <li class="active">
        <a data-toggle="tab" href="#panel_overview">
            <?=Yii::t("app","Overview")?>
        </a>
    </li>
    <li class="">
        <a data-toggle="tab" href="#panel_edit_account">
            <?=Yii::t("app","Edit Profile")?>
        </a>
    </li>
    <li class="">
        <a data-toggle="tab" href="#panel_projects">
            <?=Yii::t("app","Your history in the system")?>
        </a>
    </li>
</ul>
<div class="tab-content">
<div id="panel_overview" class="tab-pane active">
<div class="row">
    <?php $form = \yii\bootstrap\ActiveForm::begin(['id' => 'profile-form','options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data']]);?>
<div class="col-sm-5 col-md-4">
    <input name="user" value="<?=$user->per_id?>" type="hidden">
    <div class="user-left">
        <div class="center">
            <h4><?=$user->info->name?> <?=$user->info->surename?> <?=$user->info->middle_name?></h4>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="user-image">
                    <div class="fileupload-new thumbnail"><img src="/filemanager/uploads/?module=hr&folder=avatars&file=<?=$user->info->personal_picture?>&mode=photo" alt="">
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div class="user-image-buttons">
                        <span class="btn btn-teal btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-pencil"></i></span><span class="fileupload-exists"><i class="fa fa-pencil"></i></span>
                            <input type="file" name="SedPersonal[personal_picture]" id="photo-image">
                        </span>
                        <a href="#" class="btn fileupload-exists btn-bricky btn-sm" data-dismiss="fileupload">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <p>
                <a class="btn btn-twitter btn-sm btn-squared">
                    <i class="fa fa-twitter"></i>
                </a>
                <a class="btn btn-linkedin btn-sm btn-squared">
                    <i class="fa fa-linkedin"></i>
                </a>
                <a class="btn btn-google-plus btn-sm btn-squared">
                    <i class="fa fa-google-plus"></i>
                </a>
            </p>
            <hr>
        </div>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th colspan="3"> <?=Yii::t("app","Contact Information")?></th>
                <? $contact= $user->info->contact; if(!$contact){$contact=new \app\models\SedPersonalContacts(); $contact->per_id=$user->per_id;}?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?=Yii::t("app","Эл. адрес")?>:</td>
                <td>
                    <a href="">
                       <?=$contact->email?>
                    </a></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            <tr>
                <td><?=Yii::t("app","Telephone")?>:</td>
                <td><?=$contact->phone_number?></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            <tr>
                <td><?=Yii::t("app","Phone")?></td>
                <td>
                    <a href="">
                        <?=$contact->mobile_number?>
                    </a></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th colspan="3"><?=Yii::t("app","Main Information")?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?=Yii::t("app","Department")?></td>
                <td><?=$user->info->getDepartment();?></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            <tr>
                <td><?=Yii::t("app","Last Logged In")?></td>
                <td><?=$user->info->visit?></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            <tr>
                <td><?=Yii::t("app","Position")?></td>
                <td><?=$user->info->getPostionName()?></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            <tr>
                <td><?=Yii::t("app","Your roles in the system")?></td>
                <?
                $arr= $user->sedGroupsUsers;
                $txt="";
                foreach($arr as $a){
                    $txt.="<span class='badge badge-green'>".$a->group->title."</span>";
                }

                ?>
                <td><?=$txt?></td>
                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
            </tr>
            </tbody>
        </table>
    
    </div>
</div>
<div class="col-sm-7 col-md-8">
<p>
    <?=Yii::t("app","Information blocks")?>
</p>
<div class="row">
    <div class="col-sm-3">
        <a href='#' class="btn btn-icon btn-block">
            <i class="clip-clip"></i>
            <?=Yii::t("app","E-doc")?> <span class="badge badge-info"> 4 </span>
        </a>
    </div>
    <div class="col-sm-3">
        <a href='#' class="btn btn-icon btn-block" style="outline: 0px; box-shadow: rgba(196, 60, 53, 0) 0px 0px 13px; outline-offset: 20px;">
            <i class="clip-bubble-2"></i>
            <?=Yii::t("app","Message")?> <span class="badge badge-info"> 23 </span>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="#" class="btn btn-icon btn-block">
            <i class="clip-calendar"></i>
            <?=Yii::t("app","Calendar")?> <span class="badge badge-info"> 5 </span>
        </a>
    </div>
</div>
<div class="panel panel-white">
    <div class="panel-heading">
        <i class="clip-menu"></i>
        <?=Yii::t("app","Last notifications")?> 
        <div class="panel-tools">
            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
            </a>
            <a class="btn btn-xs btn-link panel-refresh" href="#">
                <i class="fa fa-refresh"></i>
            </a>
            <a class="btn btn-xs btn-link panel-close" href="#">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="panel-body panel-scroll ps-container ps-active-y" style="height:300px">
        <ul class="activities">
            <?$all=\app\models\Notification::getAll(Yii::$app->getUser()->identity->per_id); if($all)foreach($all as $a){?>
                <li>
                    <a class="activity" target="_blank" href="<?=$a->confirmaction?>">
                        <i class="clip-alarm circle-icon circle-green"></i>
                        <span class="desc"><?=$a->message?></span>
                        <div class="time">
                            <i class="fa fa-time bigger-110"></i>
                            <?=($a->status==0)? Yii::t("app","Not seen"): Yii::t("app","Seen")?>
                        </div>
                    </a>
                </li>
            <?}?>
        </ul>
        <div class="ps-scrollbar-x-rail" style="width: 675px; display: none; left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 300px; display: inherit; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 206px;"></div></div></div>
</div>
<div class="panel panel-white">
    <div class="panel-heading">
        <i class="clip-checkmark-2"></i>
        <?=Yii::t("app","Done")?>
        <div class="panel-tools">

            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
            </a>
            <a class="btn btn-xs btn-link panel-config" id="add-todo" >
                <i class="fa fa-plus"></i>
            </a>
            <a class="btn btn-xs btn-link panel-refresh" href="#">
                <i class="fa fa-refresh"></i>
            </a>
            <a class="btn btn-xs btn-link panel-close" href="#">
                <i class="fa fa-times"></i>
            </a>
        </div>
    </div>
    <div class="panel-body panel-scroll ps-container ps-active-y" style="height:300px">
        <ul class="todo">
            <?$todos=\app\models\Todo::getTodos();if($todos){foreach($todos as $todo){?>
                <li>
                    <a class="todo-actions" href="javascript:void(0)" data-rel="<?=$todo["id"]?>">
                        <i class="<?=($todo["status"]==0)?"fa fa-square-o":"fa fa-check-square-o"?>"></i>
                        <span class="desc" style="<?=($todo["status"]==0)?"opacity: 1; text-decoration: none;":"opacity: 0.25; text-decoration: line-through;"?>"><?=$todo['task']?></span>
                        <span class="label label-<?=($todo["type"]==0)?"danger":"info"?>" style="<?=($todo["status"]==0)?"opacity: 1;":"opacity: 0.25;"?>"> <?=\app\models\Todo::getTypeList()[$todo["type"]]?></span>
                    </a>
                </li>
          <?  }}?>
        </ul>
        <div class="ps-scrollbar-x-rail" style="width: 675px; display: none; left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 300px; display: inherit; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 215px;"></div></div></div>
</div>
</div>
    <?\yii\bootstrap\ActiveForm::end() ?>
</div>
</div>
<div id="panel_edit_account" class="tab-pane">
<form action="#" role="form" id="form">
<div class="row">
    <div class="col-md-12">
        <h3><?=Yii::t("app","Main Information")?></h3>
        <hr>
    </div>
    <div class="col-md-6">
        <input type="hidden" value="<?=$user->id?>" id="userid">
        <div id="notvalidretype" style="display: none;" class="alert alert-danger"><?=Yii::t("app","Done")?></div>
        <div id="successmes" style="display: none;" class="alert alert-success"></div>
        <div class="form-group">
            <label class="control-label">
                <?=Yii::t('app','Password')?>
            </label>
            <input type="password" placeholder=" <?=Yii::t('app','Password')?>" class="form-control" name="password" id="password">
        </div>
        <div class="form-group">
            <label class="control-label">
                <?=Yii::t('app','Confirm Password')?>
            </label>
            <input type="password" placeholder="<?=Yii::t('app','Confirm Password')?>" class="form-control" id="password_again" name="repassword">
        </div>
        <button type="button" id="updatepass" class="btn btn-teal btn-block">
            <?=Yii::t('app','Update')?> <i class="fa fa-arrow-circle-right"></i>
        </button>
    </div>

</div>
</form>
</div>
<div id="panel_projects" class="tab-pane">
<table class="table table-striped table-bordered table-hover" id="projects">
<thead>
<tr>
    <th class="center">
        <div class="checkbox-table">
            <label class="">
                <div ><input type="checkbox" class="flat-grey" /></div>
            </label>
        </div></th>
    <th><?=Yii::t("app","Main page")?></th>
    <th></th>
</tr>
</thead>
<tbody>
<?$cookie=Yii::$app->request->cookies->get("history"); if($cookie){$cookie=unserialize($cookie); foreach($cookie as $c){?>
    <tr>
    <td class="center">
        <div class="checkbox-table">
            <label class="">
                <input type="checkbox" class="flat-grey" >
            </label>
        </div>
    </td>
    <td><a  href="<?=$c["action"]?>"><?=$c["label"]?></a></td>
        <td>
        

        </td>
    </tr>
<?}}?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>


<div id="add-todo-modal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title"><?=Yii::t("app","Add new task")?></h4>

            </div>

            <div class="modal-body">
                <form id="todoform">
                <div class="form-group">
                    <div class="control-group">
                            <input type="text" id="tasktext" class="form-control" name="task" placeholder="задача ...">

                    </div>
                    <div class="control-group">
                        <label for="tasktype"><?=Yii::t("app","Select type")?></label>
                        <select name="type" id="tasktype" class="form-control">
                            <?foreach(\app\models\Todo::getTypeList() as $key=>$list){?>
                                <option value="<?=$key?>"><?=$list?></option>
                            <?}?>
                        </select>
                    </div>
                </div>
                </form>
            <div id="resulttodo" style="display: none"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t("app","Close")?></button>
                <button type="button" id="todosavebtn" class="btn btn-primary"><?=Yii::t("app","Add")?></button>
            </div>

        </div>

    </div>

</div>

