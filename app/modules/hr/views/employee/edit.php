<?
use app\assets\CoreAssets;
use app\models\Viloyat;
use app\models\Tuman;
use app\models\Uchastka;
use app\models\Groups;
use uni\helpers\ArrayHelper;

$user = Uni::$app->getUser()->identity;
    $groups = Groups::find()->where(['active'=>1])->andWhere(['>=','rank',$user->roles->rank])->all();

$item_group = ArrayHelper::map($groups,'id','title');

$viloyat = []; $tuman = []; $uchastka = [];

foreach (Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->all() as $v) {
    $viloyat[$v->id] = $v->name_uz;
}
if(Uni::$app->controller->access('ADMIN_VIL')){
    foreach (Tuman::find()->where(['status'=>Tuman::STATUS_ACTIVE,'viloyat_id'=>8])->all() as $v) {
        $tuman[$v->id] = $v->name_uz;
    }
}

if(Uni::$app->controller->access('ADMIN_TUM')){
    $v = Viloyat::findOne(8);
    $viloyat[$v->id] = $v->name_uz;
    $t = Tuman::findOne(95);
    $tuman[$t->id] = $t->name_uz;
    foreach (Uchastka::find()->where(['status'=>Uchastka::STATUS_ACTIVE,'tuman_id'=>95])->all() as $v) {
        $uchastka[$v->id] = $v->name_uz;
    }
}


$this->registerJsFile('/../../themes/ui/components/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/assets/js/pages/forms_advanced.js', ['depends' => [CoreAssets::className()]]);
?>
<?=Uni::$app->controller->renderPartial("/default/menu")?>

<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-2-4">
        <div id="page_content_inner">
            <h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Edit Personal Info')?></h3>
            <div class="md-card">
                <div class="md-card-content large-padding">
                    <?php $form = \uni\ui\Form::begin(['id' => 'formUchastka','options' => ['class' => 'form-horizontal',],
                        
                        'fieldConfig' => [
                            'template' => '{label}{input}{error}',
                        ],]);?> 
                    <div class="uk-form-row">
                        <?=$form->field($model, 'lastname')->textInput(['maxlength' => 64])?>
                    </div>
                    <div class="uk-form-row">
                        <?=$form->field($model, 'firstname')->textInput(['maxlength' => 64])?>
                    </div>
                    <div class="uk-form-row">
                        <?=$form->field($model, 'middlename')->textInput(['maxlength' => 64])?>
                    </div>
                    <? if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')) {?>
                        <div class="uk-form-row">
                            <?= $form->field($model, 'viloyat_id')->dropDownList($viloyat,['prompt'=>Uni::t("app", "Select region"),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 9,
                        'onchange'=>'
                            $.get("/cpanel/users/list",{id: $(this).val()},function(response){
                                $("select#sedpersonal-tuman_id").html(response);
                            });'
                        ])->label(false) ?>
                        </div>
                        <div class="uk-form-row">
                            <?=$form->field($model, 'tuman_id')->dropDownList([], ['prompt'=>Uni::t('app','Choose the town'), 'tabindex' => 10])->label(false);?>
                        </div>


                    <? }elseif (Uni::$app->controller->access('ADMIN_VIL')) {?>
                        <div class="uk-form-row">
                            <?= $form->field($model, 'viloyat_id')->dropDownList($viloyat,['disabled'=>true, 'tabindex' => 9,
                                'options'=>[1=>['Selected'=>true]]])->label(false) ?>
                        </div>
                        <div class="uk-form-row">
                            <?=$form->field($model, 'tuman_id')->dropDownList($tuman, ['prompt'=>Uni::t('app','Choose the town'), 'tabindex' => 10])->label(false);?>
                        </div>
                    <? } ?>


                    <? if (Uni::$app->controller->access('ADMIN_TUM')) {?>
                    <div class="uk-form-row">
                        <?= $form->field($model, 'viloyat_id')->dropDownList($viloyat,['disabled'=>true, 'options'=>[8=>['Selected'=>true]]])->label(false) ?>
                    </div>
                    <div class="uk-form-row">
                        <?=$form->field($model, 'tuman_id')->dropDownList($tuman, ['disabled'=>true, 'options'=>[95=>['Selected'=>true]]])->label(false);?>
                    </div>
                        
                    
                    <div class="uk-form-row">
                        <?=$form->field($model, 'hudud')->dropDownList($uchastka, ['multiple'=>'multiple','id'=>'selec_adv_1','prompt'=>Uni::t('app','Choose the hudud'), 'tabindex' => 11])->label(false);?>
                    </div>
                    <?}?>


                    <div class="uk-form-row">
                        <button type="submit" class="md-btn md-btn-success md-btn-block" id="saveUser"><?=Uni::t('app','Save')?></button>
                    </div>

                    
                    <?\uni\ui\Form::end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-width-medium-2-4">
        <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Edit Profile Info')?></h3>
        <div class="md-card">
                <div class="md-card-content large-padding">
                    <?php $form = \uni\ui\Form::begin(['id' => 'formUchastka','options' => ['class' => 'form-horizontal',],
                        
                        'fieldConfig' => [
                            'template' => '{label}{input}{error}',
                        ],]);?> 
                    <div class="uk-form-row">
                        <?=$form->field($userModel, 'email')->textInput(['maxlength' => 64])?>
                    </div>
                    <? if (!$userModel->isNewRecord) {?>
                        <div class="uk-form-row">
                            <?=$form->field($userModel, 'old_password')->passwordInput(['maxlength' => 64])?>
                        </div>
                    <?} ?>
                   
                    <div class="uk-form-row">
                        <?=$form->field($userModel, 'new_password')->passwordInput(['maxlength' => 64])?>
                    </div>
                    <div class="uk-form-row">
                        <?=$form->field($userModel, 'rpassword')->passwordInput(['maxlength' => 64])->label(Uni::t('app','Repeat new password'))?>
                    </div>
                    <div class="uk-form-row">
                        <?= $form->field($userModel, 'role')->dropDownList($item_group,['prompt'=>Uni::t("app", "Select group"),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 6])->label(false) ?>
                    </div>


                    <div class="uk-form-row">
                        <button type="submit" class="md-btn md-btn-success md-btn-block" id="saveUser"><?=Uni::t('app','Save')?></button>
                    </div>

                    
                    <?\uni\ui\Form::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
