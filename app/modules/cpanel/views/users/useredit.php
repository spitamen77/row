<?

use app\components\manager\Url;
$groups=\app\models\Groups::find()->where(['active'=>1])->all();
$arr= $model->groupsUsers;
$this->title = Uni::t('app', 'Edit').": ".$model->username;
$txt="";
if(is_array($arr))foreach($arr as $a){
    $txt.="<span class='uk-badge uk-badge-green' style='margin-right:10px;'>".$a->group->title."</span>";
}
$this->registerJs("$(\"#updatepass\").click(function(){
var passw=$(\"input[name='password']\").val();
      var repass=$(\"input[name='repassword']\").val();
      if(passw==repass){
        var userid=$(\"#userid\").val();
        $.post(\"".Url::to("cpanel/users/updateworkplace")."\",{pass:passw,user:userid,action:\"changepass\"},function(data){
            if(data=='success'){
            $(\"#successmes\").fadeOut();
            $(\"#successmes\").html('User password updated to'+passw);
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
$this->registerJs("$(\"#btngroups\").on('click',function(){
        var per = [];
        var sval=$(\"select[name='groups[]'] option:selected\");
          $(\"select[name='groups[]'] option:selected\").each(function(i, selected){
         per[i] = $(selected).val();
    });
    console.log(per);
    var userid=$(\"#userid\").val();
        $.post(\"".Url::to("cpanel/users/updateworkplace")."\",{pers:per,user:userid,action:\"changeper\"},function(data){
            console.log(data);
            location.reload();
        });
});
$(\"#btndisable\").on('click',function(){
        var sval=$(this).attr(\"data-pk\");
        $.post(\"".Url::to("cpanel/users/updateworkplace")."\",{user:sval,action:\"blockuser\"},function(data){
            location.reload();
        });
});
$(\"#generatepass\").on('click',function(){
    $(\"#passblock\").fadeOut();
    var pass=Math.random().toString(36).slice(-8);
    $(\"#passblock\").fadeIn();
    $(\"#pass\").html(pass);
    $(\"input[name='password']\").val(pass);
    $(\"input[name='repassword']\").val(pass);
});
",4);
$this->registerJs("$(\"#btnwrokplacefree\").on('click',function(){
   var userid=$(\"#userid\").val();
     $.post(\"".Url::to("cpanel/users/updateworkplace")."\",{user:userid,action:\"release\"},function(data){
            if(data=='success'){location.reload();}else{
              $(\"#workplacemess\").fadeOut();
             $(\"#workplacemess\").html(data);
            $(\"#workplacemess\").fadeIn();

            }
        });
});
",4);
$this->registerJs("$(\"#setpersonal\").on('click',function(){
   var userid=$(\"#userid\").val();
   var sval=$(\"#usermodel-id option:selected\").val();

     $.post(\"".Url::to("cpanel/users/updateworkplace")."\",{user:userid,personal:sval,action:\"setpersonal\"},function(data){
            if(data=='success'){
                location.reload();
            }else{
              $(\"#workplacemess\").fadeOut();
             $(\"#workplacemess\").html(data);
            $(\"#workplacemess\").fadeIn();

            }
        });
});
",4);

?>
    <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick="window.history.back()"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("cpanel/users/index")?>"><?=Uni::t('app','Users')?></a>
    </div>
<br class="uk-clearfix"/>
<div class="col-md-12">
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <h4>
                    <strong><?=Uni::t('app','Email')?>: <?=($model->email)?$model->email:Uni::t('app', 'Not set')?></strong>,
                    <strong><?=Uni::t('app','User Group')?>: <?=$model->roles->title?></strong>
                </h4>
                <hr class="uk-divider"/>
            </div>


        <div class="uk-width-medium-1-2">
            <h4 ><?=Uni::t('app','Change password')?></h4>
            <div>
                <button id="generatepass" class="md-btn md-btn-danger"><img id="loaderbtn" style="display: none" src="/themes/admin/images/btnloader.gif" alt="<?=Uni::t('app','Save icon')?>"/><?=Uni::t('app','Generate password')?></button>
            <br/>
                <div style="display: none" id="passblock">
                    <hr class="divider"/>
                    <span><?=Uni::t('app','Generated password')?>:</span>
                    <span class="text-green" style="font-size: 14px;" id="pass"></span>
                </div>
            </div>
            <br/>
            <div>
                <input type="hidden" value="<?=$model->id?>" id="userid">
                <div id="notvalidretype" style="display: none;" class="alert alert-danger">
                <?=Uni::t('app','Password confirmation is not valid')?></div>
                <div id="successmes" style="display: none;" class="alert alert-success"></div>
                <div class="form-group">
                    <input type="password" class="md-input" placeholder="<?=Uni::t('app','New Password')?>" name="password"/>
                </div>
                <div class="form-group">
                    <input type="password" class="md-input" placeholder="<?=Uni::t('app','Re-enter the password again')?>" name="repassword"/>
                </div>
                <br/>
                <div class="form-group">
                    <button id="updatepass" type="button" class="md-input md-btn md-btn-success" >
                        <?=Uni::t('app','Save')?></button>
                </div>
            </div>

        </div>
        <div class="uk-width-medium-1-2">
            <h4 ><?=Uni::t('app','Change permissions')?></h4>
            <div>
                <button type="button" id="btndisable" data-pk="<?=$model->id?>" class="md-btn <?=($model->status==1)?"md-btn-success": "md-btn-danger";?> "><?=($model->status==1)? Uni::t('app','Lock user') : Uni::t('app','Unblock User')?></button>
            </div>
            <br><br>
            <div>
                <h4 ><?=Uni::t('app','Select a group to use')?></h4>
                <select name="groups[]" id="userGroups" class="md-input" data-md-selectize>
                <?
                    $val=getActiveGroups($model);
                foreach ($groups as $group) {?>
                    <option value="<?=$group->id?>" <?=(in_array($group->id,[0=>$model->role]))?"selected":""?>><?=$group->title?></option>
                    <?}
                ?>
                </select>
            </div>
            <div>
                <br/>
                <button id="btngroups" type="button" class="md-btn md-btn-success"><?=Uni::t('app','Update data')?></button>
            </div>
        </div>
        </div>

    </div>


</div>
</div>
<?
function getDepartment ($model){if(isset($model->info)&&is_object($model->info->getDepartment())){
    $dep=$model->info->getDepartment();
    return $dep["department_name"];
}elseif(isset($model->info)) return $model->info->getDepartment();else return Uni::t('app','No employee attached');
}
function getActiveGroups($model){
   $res=[];
    if(isset($model->groupsUsers)){
        foreach($model->groupsUsers as $v){
            $res[]=$v->group_id;
        }
    }
    return $res;
}
?>