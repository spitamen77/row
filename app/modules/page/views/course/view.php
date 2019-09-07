<?
use app\models\Course;
$this->registerCss('.vseen{color:blue;}.wseen{color:red;}');
?>
<div class="container">
	<br>
	<br>
	<div class="row">
		<div class="col-md-3">
			<ul  class="list-group">
				<li class="list-group-item"><img src="<?=$kurs->image?>"></li>
				<li class="list-group-item"><?=$kurs->title?></li>
				<li class="list-group-item"><?=$kurs->user->makeFIO()?>.</li>
				<li class="list-group-item"><?=$kurs->subject->title?></li>
			</ul>
		</div>
		<div class="col-md-9">
			<? if($videoCount>0){ ?>
			<table class="table">
				<tr>
					<th>#</th>
					<th>Play</th>
					<th>Nomi</th>
					<th>Hajmi</th>
				</tr>
				<? $key = true;$i=0; foreach ($video as $v) { ?>
					<tr>
						<td><?=++$i?></td>
					<? if(!Uni::$app->getUser()->isGuest&&Uni::$app->access('STD')){ 
						if(Course::isView($kurs->id,$v->id)){?>
							<td><a href="<?=$this->to('page/video/view/').$v->id?>"><span class="vseen glyphicon glyphicon-play" aria-hidden="true"></span></a></td>	
						<?}else{
							if($key){ $key=false;?>
								<td><a href="<?=$this->to('page/video/view/').$v->id?>"><span class="wseen glyphicon glyphicon-play" aria-hidden="true"></span></a></td>
							<?}else{?>
								<td data-toggle="modal" data-target=".bs-example-modal-sm"><a href="#!" ><span class="glyphicon glyphicon-play" aria-hidden="true"></span></a></td>
							<?}
						}
					}else{?>
						<td class="vseen"><a href="<?=$this->to('page/video/view/').$v->id?>"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></a></td>
					<?}?>
					<td><?=$v->title?></td>
					<td>50Mb</td>
					</tr>
				<?}?>
				<tr>
					<td></td>
					<td></td>
					<td colspan="2">
						<b><a href="<?=Course::testPer($kurs->id)?$this->to('test/start/course/').$kurs->id:"#!"?>">Testni bajarish</a></b>
					</td>
				</tr>
			</table>
			<? }else{ ?>
				<h2>Bu kursga video biriktirilmagan !!!</h2>
			<?}?>
		</div>
	</div>
</div>

<!---------- Modal message ------------>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
		
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Eslatma !!!</h4>
      </div>
      <div class="modal-body">
        <p>Siz bu videoni korish uchun oldingi videoni tugatishingiz kerak.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>