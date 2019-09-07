<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Test;
$m=new \app\models\Test;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveTest();Muxr.openClearedTest();Muxr.openTestForm();
    Muxr.openEditTestForm();Muxr.openDeleteTestForm();Muxr.changeDropDownTest();
    Muxr.editTestStatus();');
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
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/test')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_test_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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

                    <th class="uk-width-1-10">Question</th>
                    <th class="uk-width-2-10">Course ID</th>
                    <th class="uk-width-2-10">Order Number</th>
                    <th class="uk-width-1-10 uk-text-center">Created Date</th>
                    <th class="uk-width-1-10 uk-text-center">Language</th>
                    <th class="uk-width-2-10 uk-text-center">Status</th>
                    <th class="uk-width-2-10 uk-text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr id='row_<?=$model->id?>'>
                    <?$st = $model->status;?>
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>
                        <td class="uk-width-2-10"><?=$model->question?></td>
                        <td class="uk-width-1-10"><?=($model->course)?$model->course->title:Uni::t('app','Not found')?></td>
                        <td class="uk-width-1-10"><?=$model->order?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->created_date?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->language?></td>
                        <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-status" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i></a></td>
                        <td class="uk-text-center">
                            
<a class="modal-edit-test" data-id="<?=$model->id?>" data-question="<?=$model->question?>" data-course="<?=$model->course_id?>" data-language="<?=$model->language?>" data-type="<?=$model->type?>" data-order="<?=$model->order?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            

                            <a class="modal-view-test"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                            <a class="modal-delete-test" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-danger">&#xE612;</i></a>

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

<!--- Modal New Test Add -->
<div class="uk-modal" id="modal_add_test">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formTest']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'question')->textArea(['row' => 4]) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'course_id')->dropDownList(\app\models\Course::getDropDown(),['id' => 'test-course']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'order')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'language')->dropDownList(\app\models\Lang::getDropDown(),['id'=>'langList']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'type')->textInput() ?>
                </div>
                <input type="hidden" id="testAdd"/>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveTest']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Notification after adding New Test -->
<div class="uk-modal" id="modal_notificationTest">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/test')?>'>
        	<?=Uni::t('app','Test list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherTest'>
        	<?=Uni::t('app','Add')?>
        </button> 
    </div>
</div>

<!---   Modal Test Edit -->
<div class="uk-modal" id="modal_edit_test">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formTestEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'question')->textArea(['row' => 4,'id' => 'testt-question']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'course_id')->dropDownList(\app\models\Course::getDropDown(),['id' => 'testt-course']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'order')->textInput(['id' => 'testt-order']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'language')->dropDownList(\app\models\Lang::getDropDown(),['id'=>'langList']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'type')->textInput(['id' => 'testt-type']) ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveTestEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Test after deletion -->
<div class="uk-modal" id="modal_deleteTest">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary">
        	<?=Uni::t('app','Back to List')?>
        </a>
        <button class="md-btn md-btn-primary" id='deleteAnotherTest'>
        	<?=Uni::t('app','Confirm')?>
        </button> 
    </div>
</div>