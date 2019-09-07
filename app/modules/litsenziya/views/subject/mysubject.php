<!-- UI X -->
<div class="ui-88">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<!-- Main heading -->
				<h4 class="bg-green">Kasblar</h4>
				<!-- Border -->
				<!-- <div class="bor"></div> -->
				<!-- UI Item -->
				<?$i=0;foreach($model as $fan): $i++;?>
				<? if($countfan/3<$i&&$i>1){$i=1;?>
					</div>
					<div class="col-md-4 col-sm-6">
					<h4></h4>
					<!-- <div class="bor"></div> -->
			
				<?} ?>
					<div class="ui-item clearfix">
						<!-- Icon -->
						<a href="<?=$this->to('users/subject/view/').$fan->fan_id?>"><i class="fa"><img width="180"  
							
							src="/themes/images/subject2.png" 
							></i></a>
						<!-- Content -->
						<p><?=$fan->subject->title?></p>
					</div>
				<?endforeach;?>
			</div>
		</div>
	</div>
</div>

<!-- 

<div class="ui-132">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<div class="ui-item">
					<div class="ui-icon">
						<a href="#" class="bg-red"><img src="themes/images/kasbicon/22.png" alt="Rasm yoq" class="img-responsive"></a>
					</div>
					<div class="ui-details">
						<h3><a href="#!">Web Designing</a></h3>
						<div class="bor bg-red"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in mauris at ante dui, faucibus nec leo mollis ullamcorper. Phasellus ut rutrum mauris. Nullam vel feugiat quam faucibus nec leo mollis.</p>
						<a href="#">Read More <i class="fa fa-angle-double-right red"></i></a>
					</div>
				</div>
				<div class="ui-item">
					<div class="ui-icon">
						<a href="#" class="bg-green"><img src="img/ui-132/2.png" alt="" class="img-responsive"></a>
					</div>
					<div class="ui-details">
						<h3><a href="#">Web Development</a></h3>
						<div class="bor bg-green"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in mauris at ante dui, faucibus nec leo mollis ullamcorper. Phasellus ut rutrum mauris. Nullam vel feugiat quam faucibus nec leo mollis.</p>
						<a href="#">Read More <i class="fa fa-angle-double-right green"></i></a>
					</div>
				</div>
				<div class="ui-item">
					<div class="ui-icon">
						<a href="#" class="bg-lblue"><img src="img/ui-132/3.png" alt="" class="img-responsive"></a>
					</div>
					<div class="ui-details">
						<h3><a href="#">Android Apps</a></h3>
						<div class="bor bg-lblue"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in mauris at ante dui, faucibus nec leo mollis ullamcorper. Phasellus ut rutrum mauris. Nullam vel feugiat quam faucibus nec leo mollis.</p>
						<a href="#">Read More <i class="fa fa-angle-double-right lblue"></i></a>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="ui-item">
					<div class="ui-icon">
						<a href="#" class="bg-purple"><img src="img/ui-132/4.png" alt="" class="img-responsive"></a>
					</div>
					<div class="ui-details">
						<h3><a href="#">JAVA Coding</a></h3>
						<div class="bor bg-purple"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in mauris at ante dui, faucibus nec leo mollis ullamcorper. Phasellus ut rutrum mauris. Nullam vel feugiat quam faucibus nec leo mollis.</p>
						<a href="#">Read More <i class="fa fa-angle-double-right purple"></i></a>
					</div>
				</div>
				<div class="ui-item">
					<div class="ui-icon">
						<a href="#" class="bg-rose"><img src="img/ui-132/5.png" alt="" class="img-responsive"></a>
					</div>
					<div class="ui-details">
						<h3><a href="#">PHP Automation</a></h3>
						<div class="bor bg-rose"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in mauris at ante dui, faucibus nec leo mollis ullamcorper. Phasellus ut rutrum mauris. Nullam vel feugiat quam faucibus nec leo mollis.</p>
						<a href="#">Read More <i class="fa fa-angle-double-right rose"></i></a>
					</div>
				</div>
				<div class="ui-item">
					<div class="ui-icon">
						<a href="#" class="bg-yellow"><img src="img/ui-132/6.png" alt="" class="img-responsive"></a>
					</div>
					<div class="ui-details">
						<h3><a href="#">Cloud Hosting</a></h3>
						<div class="bor bg-yellow"></div>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in mauris at ante dui, faucibus nec leo mollis ullamcorper. Phasellus ut rutrum mauris. Nullam vel feugiat quam faucibus nec leo mollis.</p>
						<a href="#">Read More <i class="fa fa-angle-double-right yellow"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> -->