<?=Uni::$app->controller->renderPartial("/default/menu")?>
<?
use app\components\manager\Url;
\app\components\widgets\SweetAlertAsset::register($this);
$this->title = Uni::t('app', 'Control panel')." | ".Uni::t('app', 'Groups');
?>
<div class="uk-grid">
    <div class="uk-width-medium-8-10">
        <div class="md-card">
            <div class="md-card-head-text">
                <?=Uni::t('app','List of groups')?>
            </div>
            <div class="md-card-content">
                <table class="uk-table">
                    <thead>
                    <tr>
                        <th><?=Uni::t('app','Name')?></th>
                        <th class="hidden-xs"><?=Uni::t('app','Code Name')?></th>
                        <th><i class="fa fa-time"></i><?=Uni::t('app','Created')?> </th>
                        <th class="hidden-xs"><?=Uni::t('app','Status')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($groups as $m){?>
                        <tr id="row_<?=$m->id?>">

                            <td>
                                <a href="#">
                                    <?=$m->title?>
                                </a></td>
                            <td class="hidden-xs"><?=$m->groupp?></td>
                            <td><?=date("d.m.Y",$m->created)?></td>
                            <td class="hidden-xs">
<!--                                --><?//if($m->active==1){?>
<!--                                    <span class="label label-sm label-success">-->
<!--                                    --><?//=Uni::t('app','Active')?><!--</span>--><?//}else{?>
<!--                                    <span class="label label-sm label-danger">--><?//=Uni::t('app','Blocked')?><!--</span>-->
<!--                                --><?//}?>
                                <a class="modal-edit-status" >
                                    <i data-id="<?=$m->id?>" class="md-icon material-icons uk-text-primary chstatus"><?=($m->active==1)?"&#xE834;":"&#xE835;"?></i>
                                </a>
                                <a class="modal-delete-direction" type="button" data-id="<?=$m->id ?>" data-uk-modal="{target:'#modal_delete'}"><i
                                            class="md-icon material-icons uk-text-danger">&#xE5CD;</i></a>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end: CONDENSED TABLE PANEL -->
    </div>
</div>

<?php
$this->registerJs('
    $("i.chstatus").click(function(){
            var Mstatus = $(this).attr(\'data-id\');

            console.log(Mstatus);
            $.post(\'/cpanel/default/changestatus/\'+Mstatus,{data:Mstatus},function(response){

                if(response.status == \'statusChanged\'){
                    console.log(response.status);
                    window.location.reload();
                }
                else console.log(response.status);
            });
        });
        
    $(\'.modal-delete-direction\').click(function(){
        var pk=$(this).attr("data-id");
        var url=\'../default/delete/\'+pk;
        swal({
                title: "'.Uni::t('app', 'Are you sure?').'",
                text: "'.Uni::t("app", "You will not be able to recover this information").'!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "md-btn md-btn-danger",
                confirmButtonText: "'.Uni::t("app", "Delete").'!",
                cancelButtonText: "'.Uni::t("app", "Cancel").'",
                closeOnConfirm: false
            },
            function(){
                $.post(url,{id:pk},function(data){
                    if(data.status=="success"){
                        $("#row_"+pk).remove();
                        swal("'.Uni::t("app", "Deleted").'!", "'.Uni::t("app", "Information deleted").'.", "success");
                    }else{
                        swal("'.Uni::t("app", "Not deleted").'!", "'.Uni::t("app", "The information is not deleted").'.", "error");
                    }
                });

            });

    });    
');

