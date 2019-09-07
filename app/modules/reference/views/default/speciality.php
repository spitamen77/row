<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
$m=new \app\models\Speciality;
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveSpeciality();Muxr.openClearedSpeciality();Muxr.openSpecialityForm();Muxr.openEditSpecialityForm();Muxr.openDeleteSpecialityForm();Muxr.editSpecialityStatus();');
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/speciality')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_speciality_btn" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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

                    <th class="uk-width-1-10">Title</th>
                    <th class="uk-width-2-10">Short</th>
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
                        <td class="uk-width-2-10"><?=$model->title?></td>
                        <td class="uk-width-1-10"><?=$model->short?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->created_date?></td>
                        
                        <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-statusspe" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i></a></td>
                        
                        <td class="uk-text-center">
                            
                            <a class="modal-edit-speciality" data-id="<?=$model->id?>" data-title="<?=$model->title?>" data-short="<?=$model->short?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            

                            <a class="modal-view-speciality" data-id="<?=$model->id?>" data-title="<?=$model->title?>" data-short="<?=$model->short?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                            <a class="modal-delete-speciality" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-danger">&#xE612;</i></a>

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



<!--- Modal New Video Add -->
<div class="uk-modal" id="modal_add_speciality">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formSpeciality']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'title')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'short')->textInput() ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveSpeciality']) ?>
        <?php Form::end(); ?>
    </div>
</div>
<!--  Modal Notification after adding New Video -->
<div class="uk-modal" id="modal_notificationSpeciality">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/speciality')?>'><?=Uni::t('app','Video list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherSpeciality'><?=Uni::t('app','Add')?></button> 
    </div>
</div>
<!---   Modal Speciality Edit -->

<div class="uk-modal" id="modal_edit_speciality">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formSpecialityEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'title')->textInput(['id' => 'spe-title']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'short')->textInput(['id' => 'spe-short']) ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveSpecialityEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>
<!--  Modal Speciality after deletion -->
<div class="uk-modal" id="modal_deleteSpeciality">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary"><?=Uni::t('app','Back to List')?></a>
        <button class="md-btn md-btn-primary" id='deleteAnotherSpeciality'><?=Uni::t('app','Confirm')?></button> 
    </div>
</div>