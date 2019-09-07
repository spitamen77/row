<?
use app\components\manager\Url;
use uni\helpers\Html;
use uni\ui\Form;
use app\models\Course;

$this->registerJs('Muxr.createCourse();Muxr.editCourse();Muxr.openDeleteCourse();');
$subject=new \app\models\Subject;
$m = new \app\models\Course();
$s = \app\models\Subject::find()->where(['status' => 1])->asArray()->all();
$subject = array();
foreach ($s as $key => $value) {
  $subject[$value['id']] = $value['title'];
} 


?>
 
<!--content start-->
<div class="row page-bar">
    <div class="container">
        <div class="row ">
            <div class="col-md-7 col-sm-7 col-xs-12 blog-title">
                <h1>
                  <?=Uni::$app->getUser()->getIdentity()->username;?><?=Uni::t('app','ning  Blogi')?>
                </h1>
            </div>
            <div class="col-md-5 blog_crumb">
                <ul id="breadcrumbs" class="breadcrumbs">
                    <li class="item-home">
                        <a class="bread-link bread-home" href="#" title="Home">
                        <?=Uni::t('app','Home')?></a>
                    </li>
                    <li class="separator separator-home"> /</li>
                    <li class="item-current item-1017">
                        <strong class="bread-current bread-1017"> <?=Uni::t('app','Teachers create course blog')?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Title Outer Div -->
<div class="container">

</div>

<div class="row-container row-container-1 inside bg-color" style="background-attachment:scroll;background-repeat:repeat;background-position:left top;">
  <div class="container" style="width:inside">
    <div class="row sidebar-on-left">
      <div class="col-md-3 ">
        <div class="row">
          <div class="jw-element col-md-4  jw-animate-gen animated fadeInLeft" data-gen="fadeInLeft"
          data-gen-offset="100%">

          <aside class="widget widget_video_list_widget" id="video_list_widget-5">
            <h2 class="widget-title"><?=Uni::t('app','Mening kurslarim')?>
              <span class="widtbor"></span>
            </h2>
            <?foreach($data->models as $value):?>
            <div class="widget-video-list">
              <div class="row">
                <div class="col-xs-4">
                  <a href="">
                    <img src="/themes/kasb/img/shoes-84x62.jpg" alt="Mark Of the Dragon – Epic Trailer">
                  </a>
                </div>
                <div class="col-xs-8">
                  <h5>
                    <a href="#">
                     <?=$value->title?>
                   </a>
                 </h5>
                 <div class="widget-meta">
                  <span>
                    <i class="fa fa-eye"></i> <?=$value['create_date']?>
                  </span>
                  <span>
                    <i class="fa fa-comment "></i> 
                    4</span>
                    <span class="fa fa-vimeo"></span>
                  </div>
                </div>
              </div>
            </div>
            <?endforeach;?>
          </aside>
          <aside class="widget widget_media_image" id="media_image-3">
            <img width="267" src="/themes/kasb/img/ban-250x250.png" class="image wp-image-1438  attachment-full size-full"  alt="" style="max-width: 100%; height: auto;">

          </aside>
          <aside class="widget widget_video_list_widget" id="video_list_widget-4">
            <h2 class="widget-title">Most liked
              <span class="widtbor"></span>
            </h2>

            <div class="widget-video-list">
              <div class="row">
                <div class="col-xs-4">
                  <a href="">
                    <img src="/themes/kasb/img/shoes-84x62.jpg"
                    alt="Mark Of the Dragon – Epic Trailer">
                  </a>
                </div>
                <div class="col-xs-8">
                  <h5>
                    <a href="">

                    </a></h5>
                    <div class="widget-meta">
                      <span><i class="fa fa-eye"></i> 20104</span>
                      <span><i class="fa fa-comment "></i> 4</span>
                      <span class="fa fa-vimeo"></span>
                    </div>
                  </div>
                </div>
              </div>

            </aside>
          </div>
        </div>
      </div>
      <div class="col-md-9 ">
       <!-- Here add modal started -->
       <button type="button" class="btn btn-info btn-block courseCreateBtn" data-toggle="modal" data-target="#createmodal" >Yangi kurs yaratish</button>
       <!-- Here add modal end -->

       <table class="table">
        <thead>
          <tr style="color:black;">
            <th style="color:black;"> Title</th>
            <th>Subject</th>
            <th>Short</th>
            <th>Text</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
         <?foreach($data->models as $value):?>
         <tr>
          <td><?=$value['title']?></td>
          <td> <?foreach ($s as $key => $val) {
            echo ($val['id'] == $value['fan_id']) ? $subject[$val['id']] : ''; } ?>
          </td>
          <td><?=$value['short']?></td>
          <td><?=$value['description']?></td>
          <td class="actions-icon">
            <i class="fa fa-pencil-square-o" data-toggle="modal" data-target="#editmodal" aria-hidden="true" 
             data-id="<?=$value['id']?>"
             data-title="<?=$value['title']?>"
             data-subject="<?=$value['fan_id']?>" 
             data-short="<?=$value['short']?>" 
             data-description="<?=$value['description']?>"></i>
            <i class="fa fa-eye" aria-hidden="true"></i>

            <i class="fa fa-trash-o " id="modalDeletecourse" 
            data-toggle="modal" 
            data-target="#courseDeleteModal" 
            data-deleteid="<?=$value['id']?>" 
            aria-hidden="true"></i>
          </td>

        </tr>
        <?endforeach; ?>
      </tbody>
    </table>
  </div>
   <?= uni\widgets\LinkPager::widget([
            'pagination' => $data->pagination,
            'options'=>['class' => 'uk-pagination']
        ]) ?>
</div>
</div>
</div>
<!--content end -->
 
<!-- Edit Modal -->
<div class="modal fade" id="editmodal" role="dialog">
<div class="modal-dialog modal-lg">
    <div class="modal-content" style="margin-top: 80px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
       <!-- Edit Modal Here Start -->
       <?php $form = Form::begin(['method' => 'post', 'action' => '/page/course/save', 'id' => 'editCourse']); ?>
       <div class="uk-form-row">
        <?= $form->field($m, 'title')->textInput(['tabindex' => 1, 'id' => 'edittitle']) ?>
      </div>
      <div class="uk-form-row">
        <?= $form->field($m, 'fan_id')->dropDownList($subject,['id' => 'editdir-direct','class'=>'dropDownList']) ?>
      </div>
      <div class="uk-form-row">
        <?= $form->field($m, 'short')->textInput(['tabindex' => 2, 'id' => 'editshort']) ?>
      </div>
      <div class="uk-form-row">
        <?= $form->field($m, 'description')->textarea(['tabindex' => 4, 'rows' => 3, 'id' => 'editdesc']) ?>
      </div>
      <br/>
      <div class="modal-footer">
        <?= Html::button(Uni::t('app', 'Kursni yangilash'), ['type' => 'button', 'tabindex' => 5, 'id' => 'editedSaveCourse', 'class' => 'btn btn-primary md-btn-block']) ?>
        <?php Form::end(); ?>
        <!-- Edit Modal Here End -->
      </div>
    </div>
  </div>
</div>
</div>



<!-- Create Cours Modal -->
<div id="createmodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="padding: 25px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center" >Yangi kurs yaratish</h4>
      </div>
      <!-- Add modal form here -->
      <?php $form = Form::begin(['method' => 'post', 'action' => '/page/course/save', 'id' => 'addCourse']); ?>
      <div class="uk-form-row">
        <?= $form->field($m, 'title')->textInput(['tabindex' => 1, 'id' => 'title']) ?>
      </div>
      <div class="uk-form-row">
        <?= $form->field($m, 'fan_id')->dropDownList($subject,['id' => 'dir-direct','class'=>'dropDownList']) ?>
      </div>
      <div class="uk-form-row">
        <?= $form->field($m, 'short')->textInput(['tabindex' => 2, 'id' => 'short']) ?>
      </div>
      <div class="uk-form-row">
        <?= $form->field($m, 'description')->textarea(['tabindex' => 4, 'rows' => 3, 'id' => 'desc']) ?>
      </div>
      <br/>
      <div class="modal-footer">
        <?= Html::button(Uni::t('app', 'Create'), ['type' => 'button', 'tabindex' => 5, 'id' => 'saveCourse', 'class' => 'btn btn-primary md-btn-block']) ?>
        <?php Form::end(); ?>
      </div>
    </div>
    <!-- Add modal form here -->
  </div>
</div>
<!-- modal -->

<!--  Modal Subject after deletion -->

<!-- Modal -->
<div id="courseDeleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 80px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <a class="btn btn-default" data-dismiss="modal">
          <?=Uni::t('app','Back to List')?>
        </a>
        <button class="btn btn-default " id='modalDeleteCourse'>
          <?=Uni::t('app','Confirm')?>
        </button> 
      </div>
      
    </div>

  </div>
</div>

