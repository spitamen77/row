<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Notification;
$m=new \app\models\Notification;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveNotification();Muxr.openClearedNotification();Muxr.openNotificationForm();Muxr.openEditNotificationForm();Muxr.openDeleteNotificationForm();Muxr.editNotificationStatus();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
//var_dump(Notification::$type_names);exit;
$roles = array();
$s = \app\models\Groups::find()->where(['active' => 1])->asArray()->all();
foreach ($s as $key => $value) {
    $roles[$value['id']] = $value['title'];
}
$users = array();
$s = \app\models\UserModel::find()->where(['status' => 1])->asArray()->all();
foreach ($s as $key => $value) {
    $users[$value['id']] = $value['username'];
}

?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/notification')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_notification_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
        </div>
        <div class="uk-width-1-2">
            <form method="get">
                <div class="uk-grid">
                    <div class="uk-width-3-4">
                        <input class="md-input" placeholder="<?=Uni::t('app','Search')?>" <?=$q?" value='".$q."'":""?> name="q" type="text">
                    </div>
                    <div class="uk-width-1-4">
                        <button type="submit" class="md-btn md-btn-success"><i class="material-icons">search</i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="md-card">
    <div class="md-card-content">
        <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-1-10">Type</th>
                    <th class="uk-width-2-10">Message</th>
                    <th class="uk-width-2-10">Action page</th>
                    <th class="uk-width-2-10 uk-text-center">Role</th>
                    <th class="uk-width-1-10 uk-text-center">Created Date</th>
                    <th class="uk-width-2-10 uk-text-center">Status</th>
                    <th class="uk-width-2-10 uk-text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr id='row_<?=$model->id?>'>
                    <? $st = $model->status; ?>
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-width-2-10"><?=Notification::$type_names[$model->type]?></td>
                        <td class="uk-width-2-10"><?=$model->message?></td>
                        <td class="uk-width-1-10"><?=$model->action_page?></td>
                        <td class="uk-width-1-10 uk-text-center"><?=$model->role->title?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->created_date?></td>
                        <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-notification-status" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i></a></td>
                        
                        <td class="uk-text-center">
                            
                            <a class="modal-edit-notification" data-id="<?=$model->id?>" data-type="<?=$model->type?>" data-message="<?=$model->message?>" data-action="<?=$model->action_page?>" data-role="<?=$model->role_id?>" data-user="<?=$model->user_id?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            

                            <a class="modal-view-notification" data-id="<?=$model->id?>" data-title="<?=$model->type?>" data-short="<?=$model->message?>" data-direct="<?=$model->action_page?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                            <a class="modal-delete-notification" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-danger">&#xE612;</i></a>

                        </td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination,
            'options'=>['class' => 'uk-pagination']
        ]) ?>
    </div>
    </div>


<div class="uk-notify uk-notify-top-center" style="display: none;"></div>

<!--- Modal New Subject Add -->
<div class="uk-modal" id="modal_add_notification">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formNotification']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'type')->dropDownList(Notification::$type_names) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'message')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'action_page')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'role_id')->dropDownList($roles) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'user_id')->dropDownList($users) ?>
                </div>
                <input type="hidden" id="notifcationAdd"/>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveNotification']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Notification after adding New Subject -->
<div class="uk-modal" id="modal_notificationNotification">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/notification')?>'>
            <?=Uni::t('app','Notification list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherNotification'>
            <?=Uni::t('app','Add')?>
        </button> 
    </div>
</div>

<!---   Modal Subject Edit -->
<div class="uk-modal" id="modal_edit_notification">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formNotificationEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'type')->dropDownList(Notification::$type_names,['id' => 'nott-type']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'message')->textInput(['id' => 'nott-message']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'action_page')->textInput(['id' => 'nott-action']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'role_id')->dropDownList($roles,['id' => 'nott-role']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'user_id')->dropDownList($users,['id'=>'nott-user']) ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveNotificationEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Subject after deletion -->
<div class="uk-modal" id="modal_deleteNotification">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary">
            <?=Uni::t('app','Back to List')?>
        </a>
        <button class="md-btn md-btn-primary" id='deleteAnotherNotification'>
            <?=Uni::t('app','Confirm')?>
        </button> 
    </div>
</div>
