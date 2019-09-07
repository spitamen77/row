<li class="dropdown">
    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
        <img class="circle-img" src='/themes/admin/images/lang/<?=$current->url?>.png' style="width:20px; margin-bottom:7px;" />
    </a>
    <ul class="dropdown-menu posts">
        
         <?php foreach ($langs as $lang):?>
            <li ><a style="color: #fff; font-weight: bold" href="/<?=$lang->url?><?=Uni::$app->getRequest()->getLangUrl()?>"
            title="<?=$lang->name;?>"><img src='/themes/admin/images/lang/<?=$lang->url?>.png' style="width:20px;" /><span class="badge"><?=mb_strtoupper($lang->name,'UTF-8')?></span></a>
            </li>
        <?php endforeach;?>
        </ul>
       
</li>