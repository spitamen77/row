<?
$this->registerJs("Muxr.saveUser();");
use app\components\manager\Url;
use uni\ui\Form;
$this->title = Uni::t('app', 'Edit profile');
?>

<div class="uk-grid" data-uk-grid-margin data-uk-grid-match id="user_profile">
    <div class="uk-width-large-7-10">
        <div class="uk-width-1-2">
            <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?=Url::to("cpanel/users/view")?>"><?=Uni::t('app','Users')?></a>
        </div><br>
        <div class="md-card">
            <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">

                <div class="user_heading_avatar fileinput fileinput-new">
                    <div class="fileinput-new thumbnail">
                        <img src="<?= (!empty($model->avatar)) ? $model->avatar : "/themes/ui/assets/img/avatars/user.png" ?>"
                             alt="user avatar"/>
                    </div>
                </div>
                <div class="user_heading_content">
                    <h2 class="heading_b uk-margin-bottom"><span class="uk-text-truncate"><?= $model->lastname ?> <?= $model->username ?></span>
                        <span class="sub-heading" style="font-size: 14px"><?= $model->roles->title ?></span></>
                    <ul class="user_stats">
                        <li>
                            <h4 class="heading_a"><?=Uni::t('app', 'Created')?> <span class="sub-heading"><?=date("d-m-Y", $model->created)?></span></h4>
                        </li>
                        <li>
                            <h4 class="heading_a"><?=Uni::t('app', 'Last visit')?> <span class="sub-heading"><?=($model->logged==null)? Uni::t('app', 'No visit'): date("d-m-Y", $model->logged)?></span></h4>
                        </li>

                    </ul>
                </div>

            </div>
        <div class="user_content">
            <ul id="user_edit_tabs" class="uk-tab" data-uk-tab="{connect:'#user_edit_tabs_content'}">
<!--                <li class="uk-active"><a href="#">Basic</a></li>-->
            </ul>
            <ul id="user_edit_tabs_content" class="uk-switcher uk-margin">
                <li>
                    <div class="uk-margin-top">

                        <h3 class="full_width_in_card heading_c">
                            <?=Uni::t('app', 'Settings')?>
                        </h3>
                        <? $form = Form::begin([
                            'enableClientValidation' => true,
                            'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
                        ]); ?>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2" data-uk-grid-margin="">

                                    <div>
                                        <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="md-list-addon-icon material-icons">account_box</i>
                                                                </span>
                                            <?=$form->field($model, 'lastname')->textInput(['maxlength' => 64,])?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="md-list-addon-icon material-icons"></i>
                                                                </span>
                                            <?=$form->field($model, 'phone')->textInput(['maxlength' => 64,])?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="md-list-addon-icon material-icons">account_box</i>
                                                                </span>
                                            <?=$form->field($model, 'username')->textInput(['maxlength' => 64])?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="md-list-addon-icon material-icons"></i>
                                                                </span>
                                            <?=$form->field($model, 'email')->textInput(['maxlength' => 64])?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="md-list-addon-icon material-icons">account_box</i>
                                                                </span>
                                            <?=$form->field($model, 'middlename')->textInput(['maxlength' => 64])?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-input-group">
                                                                <span class="uk-input-group-addon">
                                                                    <i class="md-list-addon-icon material-icons">description</i>
                                                                </span>
                                            <?=$form->field($model, 'avatar')->fileInput(['maxlength' => 64])?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="submit" class="md-btn md-btn-success md-btn-block"><?= Uni::t('app', 'Save') ?></button>
                                </div>
                            </div>
                        </div>
                        <? Form::end() ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>