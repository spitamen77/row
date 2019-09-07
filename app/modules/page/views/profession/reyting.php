<?
use app\models\UserModel;
$this->registerCss('.table{color:#575757;}');
?>
<div class="container">
<br>
<div class="row">
	<h3>Kasblar bo'yicha reyting</h3>
	<table class="table">
		<tr>
			<th>#</th>
			<th>Nomi</th>
			<th>Foydalanuvchilar</th>
			<th>Fanlar</th>
			<th>Kusrlar</th>
			<th>Videolar</th>
		</tr>
		<?$i=1; foreach (\app\models\Kasb::trend(3) as $val) {?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$val['kasb']?></td>
				<td><?=$val['son']?></td>
				<td><?=$val['fan']?></td>
				<td><?=$val['kurs']?></td>
				<td><?=$val['video']?></td>
			</tr>
		<?} ?>
	</table>
	<br>
	<hr>
	<br>
	<h3>Kurslar bo'yicha reyting</h3>
	<table class="table">
		<tr>
			<th>#</th>
			<th>Nomi</th>
			<th>Foydalanuvchilar</th>
			<th>Muallif</th>
			<th>Videolar</th>
			<th>Sertifikatlar</th>
		</tr>
		<?$i=1; foreach (\app\models\Course::trend(3) as $val) {?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$val['course']?></td>
				<td><?=$val['son']?></td>
				<td><?=UserModel::findOne($val['user'])?UserModel::findOne($val['user'])->makeFIO():"Mavjud emas"?></td>
				<td><?=$val['video']?></td>
				<td><?=$val['cert']?></td>
				
			</tr>
		<?} ?>
	</table>
	<br>
	<hr>
	<br>
	<h3>Videolar bo'yicha reyting</h3>
	<table class="table">
		<tr>
			<th>#</th>
			<th>Nomi</th>
			<th>Foydalanuvchilar</th>
			<th>Muallif</th>
			<th>Videolar</th>
		</tr>
		<?$i=1; foreach (\app\models\Video::trend(3) as $val) {?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$val['title']?></td>
				<td><?=$val['view']?></td>
				<td><?=UserModel::findOne($val['user_id'])?UserModel::findOne($val['user_id'])->makeFIO():"Mavjud emas"?></td>
				<td><?=date('Y-m-d',$val['created_date'])?></td>
				
			</tr>
		<?} ?>
	</table>
</div>	
</div>
