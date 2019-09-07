<?
use app\assets\CoreAssets;
use app\models\Groups;
use app\models\Viloyat;
use app\models\Tuman;
use app\models\Uchastka;
use uni\helpers\ArrayHelper;


?>
<?#=Uni::$app->controller->renderPartial("/default/menu")?>
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
                        <?=$form->field($model, 'birthday')->textInput(['tabindex' => 5]);?>
                    </div>
                    <div class="uk-width-medium-2-6">
                        <?=$form->field($model, 'personal_picture')->textInput(['tabindex' => 6]);?>
                    </div>
                </div>
                
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    
                </div>
                
            </div>



            <div class="uk-form-row">
                
            </div>
            
            
            <div class="uk-form-row">
                <button type="submit" class="md-btn md-btn-success md-btn-block" id="saveUser"><?=Uni::t('app','Save')?></button>
            </div>

            
            <?\uni\ui\Form::end() ?>
        </div>
    </div>
</div>
