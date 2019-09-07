<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
$m=new \app\models\UserModel;
        echo "<pre>";
        foreach ($dataProvider as $key => $value) {
            print_r($value);
            echo "<br>";
        }
        echo "</pre>";
        //exit;

?>

<div id="page_content_inner">
    <div class="md-card">
        <div class="md-card-content">
          <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formDirection']); ?>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-large-1-6 uk-row-first">
                <h3 class="heading_a">Sotrudnik qidirish:</h3>
                </div>
                
                    <div class="uk-width-large-4-6">
                    <!-- <div class="selectize-input items has-options"> -->
                        <?=$form->field($searchModel, 'mysearch')->textInput()?>
                        
                    <!-- </div> -->
                    </div>
                    <div class="uk-width-large-1-6">
                        <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveDirection']) ?>
                        <!-- <i class="md-icon material-icons">&#xE8B6;</i> -->
                    </div>    
                
                
            </div>
            <?php Form::end(); ?>
        </div>
    </div>
</div>