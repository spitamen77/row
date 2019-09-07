<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\helpers\ArrayHelper;
$this->title = Uni::t('app','Control Panel');
\app\components\widgets\SweetAlertAsset::register($this);
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
?>
<!--<a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="--><?//=Url::to("cpanel/users/register")?><!--">--><?//=Uni::t('app','Add new user')?><!--</a>-->
    <div class="block-process" style="margin-bottom:10px;">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("cpanel/index")?>"><?=Uni::t('app','Back')?></a>
                <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("cpanel/users/view")?>"><?=Uni::t('app','All')?></a>
                <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("cpanel/users/register")?>"><?=Uni::t('app','Add new user')?></a>
            </div>
            <div class="uk-width-1-2">
                <form method="get">
                    <div class="uk-grid">
                        <div class="uk-width-3-4">
                            <input class="md-input" placeholder="<?=Uni::t('app', 'Search')?>..." <?=$q?" value='".$q."'":""?> name="q" type="text">
                        </div>
                        <div class="uk-width-1-4">
                            <button type="submit" class="md-btn md-btn-success waves-effect waves-button waves-light"><i class="material-icons">search</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="md-card">
    <div class="md-card-toolbar"><p></p>
    <h3><?=$this->title?></h3>
</div>
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check uk-table-hover">
                <thead>
                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">№</th>

                    <th class="uk-width-2-10 uk-text-center"><?=Uni::t('app','User')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Role')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Name')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Registered')?></th>
                    <th class="uk-width-1-10 uk-text-left"><?=Uni::t('app','Phone')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Status')?></th>
                    <th class="uk-width-1-10 uk-text-center"><?=Uni::t('app','Actions')?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($query)) $dataProvider->models = $query->models; ?>
                <?php $i=0;foreach ($dataProvider->models as $model) {$i++;?>
                    <tr id="row_<?=$model->id ?>">
                        <td class="uk-text-center uk-table-middle small_col">
                            <?=$i?>
                        </td>

                        <td class="uk-text-center"><?=$model->email?></td>
                        <td class="uk-text-left"><?=($model->roles)?$model->roles->title:Uni::t('app','Not Attached')?></td>

                        <td><?=($model->personal)?$model->makeFIO():".."?></td>
                        <td class="uk-text-center"><?=date('d-m-Y',$model->created)?></td>
                        <td class="uk-text-left"><?=$model->phone?></td>

                        <td class="uk-text-center">
                            <?if($model->status==2){?>
                                <span class="uk-badge uk-badge-notification uk-badge-primary"><?=Uni::t('app','Registered')?></span>
                            <?}else{?>
                                <span class="uk-badge uk-badge-notification uk-badge-danger"><?=Uni::t('app','Not Registered')?></span>
                            <?}?>
                                
                            </td>
                        <td class="uk-text-center">
                            <a class="modal-edit-status" >
                                <i data-id="<?=$model->id?>" class="md-icon material-icons uk-text-primary chstatus"><?=($model->status==1||$model->status==2)?"&#xE834;":"&#xE835;"?></i>
                            </a>
                            <a href="<?=$this->to('cpanel/users/edit/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            <a href="<?=$this->to('reference/users/view/'.$model->id)?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>

        <?= uni\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination
        ]) ?>

    </div>
</div>
<?php
$this->registerJs('
    $("i.chstatus").click(function(){
            var Mstatus = $(this).attr(\'data-id\');

            console.log(Mstatus);
            $.post(\'/cpanel/users/changestatus/\'+Mstatus,{data:Mstatus},function(response){

                if(response.status == \'statusChanged\'){
                    console.log(response.status);
                    window.location.reload();
                }
                else console.log(response.status);
            });
        });
    $(\'.modal-delete-direction\').click(function(){
        var pk=$(this).attr("data-id");
        var url=\'../users/delete/\'+pk;
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

