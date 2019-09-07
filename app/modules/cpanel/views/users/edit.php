<?
use app\assets\CoreAssets;

$hudud = [];
foreach (\app\models\Uchastka::find()->all() as $v) {
    //$depar =$depar."{id:".$v->id.", title:'".$v->name."', url:'".$v->name."'},";
    $hudud[$v->id] = $v->name;
}
$this->registerJsFile('/../../themes/ui/components/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [CoreAssets::className()]]);
$this->registerJsFile('/../../themes/ui/assets/js/pages/forms_advanced.js', ['depends' => [CoreAssets::className()]]);
?>
<?=Uni::$app->controller->renderPartial("/default/menu")?>
<div id="page_content_inner">
    <h3 class="heading_b uk-margin-bottom"><?=Uni::t('app','Edit profile')?></h3>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <?php $form = \uni\ui\Form::begin(['id' => 'formUchastka','options' => ['class' => 'form-horizontal',],
                
                'fieldConfig' => [
                    'template' => '{label}{input}{error}',
                ],]);?> 
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'middle_name')->textInput(['maxlength' => 64,])?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'name')->textInput(['maxlength' => 64])?>
                    </div>
                     <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'surename')->textInput(['maxlength' => 64])?>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'email')->input('email',['maxlength' => 64]);?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <?=$form->field($model, 'hudud')->dropDownList($hudud, ['multiple'=>'multiple','id'=>'selec_adv_1','prompt'=>'Hududni tanlang']   );?>
                    </div>
                </div>
            </div>

            <div class="uk-form-row">
                <button type="submit" class="md-btn md-btn-success md-btn-block" id="saveUser"><?=Uni::t('app','Save')?></button>
            </div>

            
            <?\uni\ui\Form::end() ?>
        </div>
    </div>
</div>
