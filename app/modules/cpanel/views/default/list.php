<?
use app\components\manager\Url;

?>
<hr class="divider"/>
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-default">

            <div class="panel-heading">
                <?=Url('app','Control Panel')?>
            <span id="loader" class="pull-right" style="display: none;">
            <img src="/themes/admin/images/ajax-loader.gif">
        </span>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">

                <?=Uni::$app->controller->renderPartial("/default/menu")?>
            </div>

        </div>
        <div id="content">
            <div class="col-md-12">
                <a href="<?=Url::to("cpanel/users/register")?>" class="btn btn-sm btn-success "><i class="glyphicon glyphicon-pencil"></i><?=Url('app','Add work place')?></a>
                <hr/>
            </div>

            <?
            use kartik\grid\GridView;
            use uni\helpers\Html;

            use uni\helpers\ArrayHelper;
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $search,
                'responsive' => false,
                'resizableColumns'=>false,
                'hover' => true,
                'export' => false,
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => true,
                'layout' => "{items}\n{pager}",
                'pjaxSettings' => [
                    'neverTimeout' => true,
                ],
                'toolbar' => [
                    ['content'=>
                        Html::button('&lt;i class="glyphicon glyphicon-plus">&lt;/i>', ['type'=>'button', 'title'=>Uni::t('app', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                        Html::a('&lt;i class="glyphicon glyphicon-repeat">&lt;/i>', ['grid-demo'], ['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Uni::t('app', 'Reset Grid')])
                    ],
                    '{toggleData}',
                    '{export}',
                ],
                'exportConfig' => [
                    GridView::CSV => ['label' => 'Save as CSV'],
                ],
                'columns' => [
                    ['class' => '\kartik\grid\CheckboxColumn'],
                    ['class' => 'uni\grid\SerialColumn'],
                    [
                        'attribute'=>'photo',
                        'value'=>function ($model,$key, $index, $widget){
                            if(!isset($model->info)) return "Not personal picture set";
                            return "<img class='img-rounded' src='http://erp.loc/filemanager/uploads/?module=hr&folder=avatars&file={$model->info->personal_picture}'/>";
                        },
                        'format'=>'raw',
                        'noWrap'=>true
                    ],
                    'login',
                    [
                        "attribute"=>'name',
                        'value'=>function($model,$key, $index, $widget){
                            if(!isset($model->info)) return "Not personal set";
                            return $model->info->makeFIO();
                        },
                        'format'=>'raw',

                    ],
                    [
                        'attribute'=>'status',
                        'value'=>function($model,$key, $index, $widget){
                            if(!isset($model->info)) return "Not personal set";
                            return $model->info->getStatusName();},
                        'filter' => \uni\helpers\ArrayHelper::map(app\models\Personal::getStatnames(),'status','name')
                    ],
                    [
                        "attribute"=>'depar_id',
                        'value'=>function($model,$key, $index, $widget){
                            if(!isset($model->info)) return "Not personal set";
                            if(is_object($model->info->getDepartment())){
                                $dep=$model->info->getDepartment();
                                return $dep["department_name"];
                            }else return $model->info->getDepartment();
                        },
                        'filter' => ArrayHelper::map(app\models\DepartmentList::find()->orderBy([])->all(),'did','department_name')
                    ],
                    ["attribute"=>'position',
                        "value"=>function($model){

                            if(!isset($model->info)) return "Not personal set";
                            return $model->info->getPostionName();
                        },
                        'filter' => ArrayHelper::map(app\models\Positions::find()->orderBy([])->all(),'id','title')
                    ],
                    ["attribute"=>'groups',
                        "value"=>function($model){
                            $arr= $model->sedGroupsUsers;
                            $txt="";
                            foreach($arr as $a){
                                $txt.="<span class='badge badge-green'>".$a->group->title."</span>";
                            }
                            return $txt;
                        },
                        'format'=>'raw',
                        'filter' => ArrayHelper::map(app\models\Groups::find()->all(),'id','title')
                    ],

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'options' => ['class' => 'col-md-2'],
                        'dropdown' => false,
                        'vAlign'=>'middle',
                        'template' => '{view} {update} {status} {trash}',
                        'buttons' => [
                            //view button
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span>', $url, [
                                    'title' => Uni::t('app', 'View'),
                                    'class'=>'btn btn-primary ',
                                    'target'=>'_blank',
                                ]);},
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-edit"></span>', $url, [
                                    'title' => Uni::t('app', 'Update'),
                                    'class'=>'btn btn-success',
                                    'data-toggle'=>'tooltip'
                                ]);
                            },
                            'status' => function ($url, $model) {
                                return Html::button('<span class="fa fa-ban"></span>', [
                                    'title' => Uni::t('app', 'Status'),
                                    'class'=>'btn btn-info status',
                                    'data-val'=>$model->id,
                                    'data-message'=>$url,
                                ]);
                            },
                            'trash' => function ($url, $model) {
                                return Html::button('<i class="fa fa-trash-o"></i>',  [
                                    'title' => Uni::t('app', 'Delete'),
                                    'class'=>'btn btn-danger delete',
                                    'data-val'=>$model->id,
                                ]);
                            },
                            'message' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash-o"></span>', $url, [
                                    'title' => Uni::t('app', 'Delete'),
                                    'class'=>'btn btn-warning ',

                                ]);
                            },
                        ],
                        'urlCreator' => function($action, $model, $key, $index) {
                            $url="";
                            if($action=="view")$url=\app\components\manager\Url::to("staff/".$model->id);
                            else if($action=="update")$url=\app\components\manager\Url::to("cpanel/users/edit/".$model->id);
                            else if($action=="delete")$url=\app\components\manager\Url::to("cpanel/users/delete/".$model->id);
                            else if($action=="status")$url=\app\components\manager\Url::to("cpanel/users/status/".$model->id);
                            return $url; },
                    ],
                ],
            ]);?>
        </div>

    </div>
    <div class="col-md-3">
        <?=(new \app\components\widgets\SysInfo())->sysinfo()?>
    </div>
</div>
