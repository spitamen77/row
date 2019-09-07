<?
use app\assets\CoreAssets;
use app\models\Groups;
use app\models\Viloyat;
use app\models\Tuman;
use app\models\Uchastka;
use uni\helpers\ArrayHelper;

$user = Uni::$app->getUser()->identity;
//if(Uni::$app->access("TUM")){
    $groups = Groups::find()->where(['active'=>1])->andWhere(['>=','rank',$user->roles->rank])->all();
//}

$item_group = ArrayHelper::map($groups,'id','title');
$viloyat = []; $tuman = []; $uchastka = [];

foreach (Viloyat::find()->where(['status'=>Viloyat::STATUS_ACTIVE])->all() as $v) {
    $viloyat[$v->id] = $v->name_uz;
}
if(Uni::$app->controller->access('ADMIN_VIL')){
    foreach (Tuman::find()->where(['status'=>Tuman::STATUS_ACTIVE,'viloyat_id'=>$user->personal->viloyat_id])->all() as $v) {
        $tuman[$v->id] = $v->name_uz;
    }
}

if(Uni::$app->controller->access('ADMIN_TUM')){
    $v = Viloyat::findOne($user->personal->viloyat_id);
    $viloyat[$v->id] = $v->name_uz;
    $t = Tuman::findOne($user->personal->tuman_id);
    $tuman[$t->id] = $t->name_uz;
    foreach (Uchastka::find()->where(['status'=>Uchastka::STATUS_ACTIVE,'tuman_id'=>$user->personal->tuman_id])->all() as $v) {
        $uchastka[$v->id] = $v->name_uz;
    }
}

$this->title = Uni::t('app','Human recources')." | ".Uni::t('app','Add employee');
$this->registerJsFile('/../../themes/ui/components/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/assets/js/pages/forms_advanced.js', ['depends' => [CoreAssets::className()]]);
?>
<?=Uni::$app->controller->renderPartial("/default/menu")?>
<div id="page_content_inner">
    <h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Add profile')?></h3>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <?php $form = \uni\ui\Form::begin(['id' => 'formUchastka','options' => ['class' => 'form-horizontal',],
                
                'fieldConfig' => [
                    'template' => '{label}{input}{error}',
                ],]);?> 
            <h2 class="heading_b">
                <?#=(Uni::$app->getUser()->identity->viloyat)?Uni::$app->getUser()->identity->viloyat->name:Uni::t("app","Region not found")?>
                <!-- <span class="sub-heading"><?#=(Uni::$app->getUser()->identity->tuman)?Uni::$app->getUser()->identity->tuman->name:Uni::t("app","City or town not found")?></span> -->
            </h2>
            <hr class="md-hr">
            <br>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'lastname')->textInput(['tabindex' => 1])?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'firstname')->textInput(['tabindex' => 2])?>
                    </div>
                     <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'middlename')->textInput(['tabindex' => 3])?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($model, 'phone')->textInput(['tabindex' => 4]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($userModel, 'email')->input('email',['tabindex' => 5]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($userModel, 'role')->dropDownList($item_group,['prompt'=>Uni::t("app", "Select group"),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 6])->label(false) ?>
                    </div>
                </div>
                
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($userModel, 'password')->passwordInput(['required' => 'required', 'class'=>'md-input','tabindex' => 7]) ?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?= $form->field($userModel, 'rpassword')->passwordInput(['required' => 'required', 'class'=>'md-input','tabindex' => 8]) ?>
                    </div>
                </div>
                
            </div>



            <div class="uk-form-row">
                
            </div>
            
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>


                    <? if (Uni::$app->controller->access('HEAD')||Uni::$app->controller->access('ADMIN')) {?>
                        <div class="uk-width-medium-1-3">
                            <?= $form->field($model, 'viloyat_id')->dropDownList($viloyat,['prompt'=>Uni::t("app", "Select region"),'data-uk-tooltip'=>'{pos:\'top\'}','class'=>'md-input','tabindex' => 9,
                        'onchange'=>'
                            $.get("/cpanel/users/list",{id: $(this).val()},function(response){
                                $("select#sedpersonal-tuman_id").html(response);
                            });'
                        ])->label(false) ?>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <?=$form->field($model, 'tuman_id')->dropDownList([], ['prompt'=>Uni::t('app','Choose the town'), 'tabindex' => 10])->label(false);?>
                        </div>


                    <? }elseif (Uni::$app->controller->access('ADMIN_VIL')) {?>
                        <div class="uk-width-medium-1-3">
                            <?= $form->field($model, 'viloyat_id')->dropDownList($viloyat,['disabled'=>true, 'tabindex' => 9,
                                'options'=>[$user->personal->viloyat_id=>['Selected'=>true]]])->label(false) ?>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <?=$form->field($model, 'tuman_id')->dropDownList($tuman, ['prompt'=>Uni::t('app','Choose the town'), 'tabindex' => 10])->label(false);?>
                        </div>
                    <? } ?>


                    <? if (Uni::$app->controller->access('ADMIN_TUM')) {?>
                    <div class="uk-width-medium-1-3">
                        <?= $form->field($model, 'viloyat_id')->dropDownList($viloyat,['disabled'=>true, 'options'=>[$user->personal->viloyat_id=>['Selected'=>true]]])->label(false) ?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'tuman_id')->dropDownList($tuman, ['disabled'=>true, 'options'=>[$user->personal->tuman_id=>['Selected'=>true]]])->label(false);?>
                    </div>
                        
                    
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'hudud')->dropDownList($uchastka, ['multiple'=>'multiple','id'=>'selec_adv_1','prompt'=>Uni::t('app','Choose the hudud'), 'tabindex' => 11])->label(false);?>
                    </div>
                    <?}?>
                </div>
            </div>
            <div class="uk-form-row">
                <button type="submit" class="md-btn md-btn-success md-btn-block" id="saveUser"><?=Uni::t('app','Save')?></button>
            </div>

            
            <?\uni\ui\Form::end() ?>
        </div>
    </div>
</div>
