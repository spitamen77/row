<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Test;
$m=new \app\models\Answer;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveAnswer();Muxr.openClearedAnswer();Muxr.openAnswerForm();
    Muxr.openEditAnswerForm();Muxr.openDeleteAnswerForm();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
// $speciality = array();
// $s = \app\models\Course::find()->where(['status' => 1])->asArray()->all();
// foreach ($s as $key => $value) {
//     $speciality[$value['id']] = $value['title'];
// }
// // $direction = array();
// // $s = Direction::find()->where(['status' => 1])->asArray()->all();
// foreach ($s as $key => $value) {
//     $speciality[$value['id']] = $value['title'];
// }

?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/answer')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_answer_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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
                    <th class="uk-width-1-10">Test ID</th>
                    <th class="uk-width-2-10">Answer</th>
                    <th class="uk-width-2-10 uk-text-center">Right</th>
                    <th class="uk-width-2-10 uk-text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr id='row_<?=$model->id?>'>
                    
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-width-2-10"><?=($model->test)?$model->test->question:Uni::t('app', 'Not found')?></td>
                        <td class="uk-width-1-10"><?=$model->answer?></td>
                        <td class="uk-width-1-10 uk-text-center"><?=$model->right?></td>
                        
                        <td class="uk-text-center">
                            
                        <a class="modal-edit-answer" data-id="<?=$model->id?>" data-test="<?=$model->test_id?>" data-answer="<?=$model->answer?>" data-right="<?=$model->right?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            

                            <a class="modal-view-answer"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                            <a class="modal-delete-answer" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-danger">&#xE612;</i></a>

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

<!--- Modal New Answer Add -->
<div class="uk-modal" id="modal_add_answer">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formAnswer']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'test_id')->dropDownList(\app\models\Test::getDropDown(),['id' => 'ans-test']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'answer')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'right')->textInput() ?>
                </div>
                <input type="hidden" id="testAdd"/>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveAnswer']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Notification after adding New Answer -->
<div class="uk-modal" id="modal_notificationAnswer">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/answer')?>'>
        	<?=Uni::t('app','Answer list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherAnswer'>
        	<?=Uni::t('app','Add')?>
        </button> 
    </div>
</div>

<!---   Modal Answer Edit -->
<div class="uk-modal" id="modal_edit_answer">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formAnswerEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'test_id')->dropDownList(\app\models\Test::getDropDown(),['id' => 'an-test']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'answer')->textInput(['id' => 'an-answer']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'right')->textInput(['id' => 'an-right']) ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveAnswerEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Answer after deletion -->
<div class="uk-modal" id="modal_deleteAnswer">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary">
        	<?=Uni::t('app','Back to List')?>
        </a>
        <button class="md-btn md-btn-primary" id='deleteAnotherAnswer'>
        	<?=Uni::t('app','Confirm')?>
        </button> 
    </div>
</div>