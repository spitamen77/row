<?

//use uni\components\manager\Url;



?>

<div class="thumb-box3">
<div class="container">
    <p class="title wow fadeInLeft animated"><?=$catname->title?></p>
    <?if($subjectsCount!=0){?>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <ul class="list1-1">
        <? 
        $count = $subjectsCount/3 + 1;
        $i=1;
        foreach ($subjects as $subject) {
            if($i>$count){ $i=1;?>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <ul class="list1-1">
            <?}?>
            <li>
                <a href="<?=$this->to('page/subject/course/').$subject->id?>"><?=$subject->title?></a>
            </li>
            <? $i++; } ?>
            </ul>
        </div>
    </div>
    <?}else{?>
        <div class="alert alert-danger" role="alert">Bu kategoriyada fan mavjud emas !!!</div>
    <?}?>    
</div>
</div>
