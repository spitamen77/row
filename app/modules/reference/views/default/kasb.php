<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Direction;
use app\models\Kasb;
$m = new Kasb();
$languages=\app\models\Lang::find()->all();
\app\components\widgets\SweetAlertAsset::register($this);
$this->registerJs('Muxr.saveKasb();Muxr.openClearedKasb();Muxr.openKasbForm();Muxr.openEditKasbForm();Muxr.openDeleteKasbForm();Muxr.editKasbStatus();Muxr.changeDropDownDirection();$("#dir-fan-edit").selectize();'
);
$q=false;
if(isset($_GET['q'])){
    $q=$_GET['q'];
}
$speciality = array();
$s = \app\models\Speciality::find()->where(['status' => 1])->asArray()->all();
foreach ($s as $key => $value) {
    $speciality[$value['id']] = $value['title'];
}
$fan = array();
$s = \app\models\Subject::find()->where(['status' => 1])->asArray()->all();
foreach ($s as $key => $value) {
    $fan[$value['id']] = $value['title'];
}
?>
<div class="block-process" style="margin-bottom:10px;">
    <div class="uk-grid">
        <div class="uk-width-1-2">
        <a class="md-btn md-btn-success md-btn-small" href="<?=Url::to('reference/default/index')?>"><?=Uni::t('app','Back')?></a>
        <a class="md-btn md-btn-primary md-btn-small" href="<?=$this->to('reference/default/kasb')?>"><?=Uni::t('app','All')?></a>
        <button id="modal_add_kasb_btn" data-uk-modal="{bgClose:true;modal:true}" class="md-btn md-btn-facebook md-btn-small" ><?=Uni::t('app','Add')?></button>
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
                    <th class="uk-width-2-10">Speciality</th>
                    <th class="uk-width-1-10 uk-text-center">Attached subjects</th>
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
                        <td class="uk-width-1-10"><?=($model->speciality)?$model->speciality->title:Uni::t('app','Not found')?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->countSubjects()?></td>
                        <td class="uk-width-2-10 uk-text-center"><?=$model->created_date?></td>
                        <td class="uk-width-2-10 uk-text-center"><a class="modal-edit-status-kasb" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-primary"><?=($st==0)?"&#xE835;":"&#xE834;"?></i></a></td>
                        
                        <td class="uk-text-center">
                            
                            <a class="modal-edit-kasb" data-id="<?=$model->id?>" data-title="<?=$model->title?>" data-short="<?=$model->short?>" data-direct="<?=$model->soha_id?>"><i class="md-icon material-icons uk-text-primary">&#xE254;</i></a>
                            

                            <a class="modal-view-kasb" href="<?=Url::to('reference/kasb/view/').$model->id?>" data-id="<?=$model->id?>" data-title="<?=$model->title?>" data-short="<?=$model->short?>"><i class="md-icon material-icons uk-text-primary">&#xE417;</i></a>

                            <a class="modal-delete-kasb" data-id="<?=$model->id?>"><i class="md-icon material-icons uk-text-danger">&#xE612;</i></a>

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

<!--- Modal New Kasb Add -->
<div class="uk-modal" id="modal_add_kasb">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => false,'id'=>'formKasb']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'title')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'short')->textInput() ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'soha_id')->dropDownList($speciality,['id' => 'dir-direct']) ?>
                </div>

                <div class="uk-form-row">
                    <?= $form->field($m, 'direction_id')->dropDownList([],['id' => 'dir-direction']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'fan')->dropDownList([],['id' => 'dir-fan', 'multiple'=>'multiple']) ?>
                </div>
                <input type="hidden" id="kasbAdd"/>
                <br/>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveKasb']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Notification after adding New Kasb -->
<div class="uk-modal" id="modal_notificationKasb">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary" href='<?=Url::to('reference/default/kasb')?>'>
        	<?=Uni::t('app','Video list')?></a>
        <button class="md-btn md-btn-primary" id='addAnotherKasb'>
        	<?=Uni::t('app','Add')?>
        </button> 
    </div>
</div>

<!---   Modal Kasb Edit -->
<div class="uk-modal" id="modal_edit_kasb">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
         <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formKasbEdit']); ?>
                <div class="uk-form-row">
                    <?= $form->field($m, 'title')->textInput(['id' => 'dir-title']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'short')->textInput(['id' => 'dir-short']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'soha_id')->dropDownList($speciality,['id' => 'dir-directt']) ?>
                </div>
                <div class="uk-form-row">
                    <?= $form->field($m, 'fan')->dropDownList($fan,['id' => 'dir-fan-edit','multiple'=>'multiple']) ?>
                </div>
                <br/>
                <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block', 'id'=>'saveKasbEdit']) ?>
        <?php Form::end(); ?>
    </div>
</div>

<!--  Modal Kasb after deletion -->
<div class="uk-modal" id="modal_deleteKasb">
    <div class="uk-modal-dialog" style="min-height: 400px">
        <button type="button" class="uk-modal-close uk-close"></button>
        <a class="md-btn md-btn-primary">
        	<?=Uni::t('app','Back to List')?>
        </a>
        <button class="md-btn md-btn-primary" id='deleteAnotherKasb'>
        	<?=Uni::t('app','Confirm')?>
        </button> 
    </div>
</div>