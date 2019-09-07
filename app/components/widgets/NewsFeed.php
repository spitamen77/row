<?php
namespace app\components\widgets;
use app\models\FeastDays;

class NewsFeed{
    public $str="";
    public function getList(){
        $r="";
        $m=date("m");
        $content=file_get_contents(\Uni::getAlias("@rootPath").'\\cache\\birth-list.json');
        $array=json_decode($content,true);
        if(isset($array[$m])){
            ksort($array[$m]);
            $i=0;
            foreach($array[$m] as $a){
                if($i>=3)exit;
                foreach($a as $b){
                    if($i>=3)exit;
                    $i = ucfirst(substr(trim($b["name"]), 0,2));
                    $o = ucfirst(substr(trim($b["middle_name"]), 0,2));
                    $string = ucfirst(trim($b["name"])).' '.$i.'.'.$o;
                    $i++;
                $r.="<div class='col-md-4'>
                      <h5 class='label label-success'>".date("d.m.Y",$b["birth"])."</h5>
                    <img src='/filemanager/uploads/?module=hr&folder=avatars&file=".$b["image"]."&mode=icon' class='circle-img'/>
                    <h5>".$string."</h5>
                </div>";
                }
            }
        }
        return $r;
    }
    public function getLastFeasts(){
        $day=date("d");
        $month=date('m');
        $feast=FeastDays::find()->where("month>='$month' and day>='$day'")->asArray()->orderBy(['day'=>SORT_ASC,'month'=>SORT_ASC])->limit(1)->all();
        $result="";

        if($feast)foreach($feast as $as){
            $result.=$as['title'];
        }
        return $result;
    }
    public function toString(){
        $this->str .= '
                    <div class="col-lg-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                        <i class="clip-note"></i> Новости
                                        <div class="pull-right"  id="wait" style="display: none;">
                                            <img class="float-right" style="width: 20px;" src="/themes/admin/images/ajax-loader.gif">
                                        </div>
                                </div>
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
                                <ul id="myTab" class="nav nav-tabs">
                                    <li class="rss active" id="" ><a href="http://www.qml.uz/rsscontent" >Новости компании</a></li>
                                    <li class="rss " id="gazeta_uz"><a href="http://www.gazeta.uz/rss/" >Газета.Uz</a>
                                    </li>
                                    <li class="rss" id="lex_uz"><a href="http://lex.uz/ru/rss/">Lex.Uz</a>
                                    </li>
                                    <li class="rss" id="press_uz"><a href="http://www.press-service.uz/ru/rss">Пресс-Служба</a>
                                    </li>
                                    <li class="rss" id="gov_uz"><a href="http://www.gov.uz/ru/press/rss/">Gov.Uz</a>
                                    </li>
                                    <li class="rss" id="24_uz"><a href="http://uz24.uz/rss.php?lang=ru">24.Uz</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="rssContent">
                                <div id="rss-real-content"></div>
                                    <div id="company_news">
                                    <div class="col-md-6"><h5 class="text-center">Предстоящие дни рождения</h5>'.$this->getList().'</div>
                                    <div class="col-md-6">
                                    <h5 class="text-center">Ближайшие праздники</h5>
                                        <h4>   '.$this->getLastFeasts().'</h4>
                                            <img src="/themes/admin/images/feast_day.jpg" class="image-responsive" style="width:250px;"/>
                                    </div>
                                    </div><br style="clear:both"/>
                                </div>
                            </div>
                        </div>
                    </div>

            ';

        return $this->str;
    }
}