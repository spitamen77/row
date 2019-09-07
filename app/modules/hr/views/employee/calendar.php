<?
use app\components\widgets\Calendar;
$this->registerCssFile("/css/fullcalendar.min.css");
$this->registerCssFile("/includes/bootstrap-modal/css/bootstrap-modal-bs3patch.css");
$this->registerCssFile("/includes/bootstrap-modal/css/bootstrap-modal.css");
$this->registerJsFile("/includes/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js",['depends' => [
    'app\assets\HrAssets']]);
$this->registerJsFile("/includes/moment/min/moment.min.js",['depends' => [
    'app\assets\HrAssets']]);
$this->registerJsFile("/themes/admin/js/fullcalendar/fullcalendar.min.js",['depends' => [
    'app\assets\HrAssets']]);
$this->registerJsFile("/themes/admin/js/fullcalendar/ru.js",['depends' => [
    'app\assets\HrAssets']]);
	$this->registerJsFile("/themes/admin/js/fullcalendar/calendar.js",['depends' => [
    'app\assets\HrAssets']]);


?>
<hr class="divider">
<div class="row">
    <div class="col-sm-12">
        <!-- start: FULL CALENDAR PANEL -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <?=Yii::t('app','Full calendar')?>
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                   <?=(new Calendar())->withoutPanel()?>
                </div>
                
            </div>
        </div>
   
    </div></div>