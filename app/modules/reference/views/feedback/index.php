<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
$m = new\app\models\Feedback;
$this->registerJs('Muxr.sendMessage();Muxr.openFeedview();');
?>
<div class="block-process" style="margin-bottom:10px;">
    <a class="md-btn md-btn-success" href="<?=Url::to('/reference/default/index')?>"><?=Uni::t('app','Back')?></a>
</div>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-nowrap table_check">
                <thead>

                <tr>
                    <th class="uk-width-1-10 uk-text-center small_col">
                        <input type="checkbox" data-md-icheck class="check_all"></th>

                    <th class="uk-width-2-10">Name</th>
                    <th class="uk-width-2-10 uk-text-center">Email</th>
                    <th class="uk-width-1-10 uk-text-center">Subject</th>
<!--                    <th class="uk-width-1-10 uk-text-center">Text</th>-->
                    <th class="uk-width-1-10 uk-text-center">Date</th>
                    <th class="uk-width-2-10 uk-text-center">Status</th>
                    <th class="uk-width-2-10 uk-text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($data->models as $model) {?>
                    <tr>
                        <td class="uk-text-center uk-table-middle small_col">
                            <input type="checkbox" data-md-icheck class="check_row"/>
                        </td>

                        <td><?=$model->name?> </td>
                        <td class="uk-text-center"><?=$model->email?></td>
                        <td class="uk-text-center"><?=$model->subject?></td>
<!--                        <td class="uk-text-center">--><?//=$model->text?><!--</td>-->
                        <td class="uk-text-center"><?= $model->date?></td>
                        <td class="uk-text-center">
                            <?if($model->status){?> <span class="uk-badge">Active</span><?}else{?>
                                <span class="uk-badge uk-badge-danger">inActive</span>
                            <?}?>
                        </td>
                        <td class="uk-text-center">
                            <a id="opensendmessageform">
                                <i class="md-icon material-icons uk-text-primary">&#xE254;</i>
                            </a>

                            <a href="#">
                                <i id="openFeedbackView" data-name="<?=$model->name?>" data-text="<?=$model->text;?>" class="md-icon material-icons uk-text-danger">&#xE417;</i></a>

                            <a href="<?=$this->to('reference/users/changestatus/'.$model->id)?>" >
                                <?if($model->status){?> <i class="md-icon material-icons uk-text-success">&#xE86C;</i><?}else{?>
                                    <i class="md-icon material-icons uk-text-warning">&#xE612;</i>
                                <?}?>
                            </a>
                        </td>
                    </tr>
                <?}?>

                </tbody>
            </table>
        </div>
        <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination
        ]) ?>

    </div>
</div>



<div class="uk-notify uk-notify-top-center" style="display: none;"></div>

<!--- Modal Send Message Add -->
<div class="uk-modal" id="modal_send_message_form">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <?php $form = Form::begin(['enableAjaxValidation' => true,'id'=>'formSubject']); ?>
        <div class="uk-form-row">
            <?= $form->field($m, 'name')->textInput() ?>
        </div>
        <div class="uk-form-row">
            <?= $form->field($m, 'text')->textInput() ?>
        </div>

        <input type="hidden" id="subjectAdd"/>
        <br/>
        <?= Html::button(Uni::t('app', 'Save'), ['type'=>'button','class' => 'md-btn md-btn-primary md-btn-block','id'=>'saveSubject']) ?>
        <?php Form::end(); ?>
    </div>
</div>


<!--- Modal Open Feedback Form View-->
<div class="uk-modal" id="modal_open_feedback_form">
    <div class="uk-modal-dialog">
        <button type="button" class="uk-modal-close uk-close"></button>
        <h5 align="center ">By <h5 id="feed-user"></h5></h5>
        <hr>
        <h3 id="feed-text">
            Here write text :
        </h3>
    </div>
</div>

