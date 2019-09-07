<?
$user=Uni::$app->user->identity;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><?=Uni::t('app','Change Password')?></div>
    </div>
    <div class="panel-body">
        <?php $form = \uni\ui\Form::begin([
            'id' => 'admin-edit-form',
            'options' => ['class' => 'form-vertical','role' => 'form','validateOnSubmit' => true,],
            'enableClientValidation' => true,
        ]); ?>
        <form id="admin-edit-form" class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-3">
                        <div class="person-photo-holder">
                            <img src="filemanager/uploads/?module=hr&folder=avatars&file=<?=$user->info->personal_picture?>&mode=photo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?=$form->field($user,"login")->textInput()?>

                        <?=$form->field($user,"password")->passwordInput()?>
                        <?=$form->field($user,"rpassword")->passwordInput()?>

                        <div class="form-group" id="admin_password_confirm_group">
                            <label><?=Uni::t('app','Confirm password')?></label>
                            <input type="password" name="admin_password_confirm" id="admin_passwor_confirm" class="form-control" placeholder="">
                            <span class="help-block form-errors" id="admin_password_confirm_notice"><label></label></span>
                        </div>
                        <input type="hidden" name="action" value="save_admin">
                        <button type="button" id="save-admin" class="btn btn-success pull-right"><?=Uni::t('app','Save')?></button>
                        <!--                    <a href="javascript:history.back()" class="btn btn-warning">Отменить</a>-->
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" id="user_role_group">
                            <label><?=Uni::t('app','Group')?></label>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[7]" value="0">
                                    <input type="checkbox" name="group[7]" value="1" checked="">

                                    <?=Uni::t('app','Admin')?>                            </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[8]" value="0">
                                    <input type="checkbox" name="group[8]" value="1" checked="">

                                   <?=Uni::t('app',' Human Resources Department')?>                          </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[9]" value="0">
                                    <input type="checkbox" name="group[9]" value="1" checked="">

                                    <?=Uni::t('app','EDO Users')?>                           </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[10]" value="0">
                                    <input type="checkbox" name="group[10]" value="1">

                                    <?=Uni::t('app','User')?>                            </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[11]" value="0">
                                    <input type="checkbox" name="group[11]" value="1" checked="">

                                    <?=Uni::t('app','EDO Editor')?>                            </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[12]" value="0">
                                    <input type="checkbox" name="group[12]" value="1">

                                    <?=Uni::t('app','Management')?>                     </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[13]" value="0">
                                    <input type="checkbox" name="group[13]" value="1" checked="">

                                    <?=Uni::t('app','Heads of departments')?>                         </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="group[14]" value="0">
                                    <input type="checkbox" name="group[14]" value="1" checked="">

                                    <?=Uni::t('app','CRM System')?>                            </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php \uni\ui\Form::end(); ?>
    </div>

</div>