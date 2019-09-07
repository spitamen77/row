<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 30.06.2015
 * Time: 0:45
 */

namespace app\components\widgets;


class SysInfo {
    public $conf;
    public function sysinfo(){
        $str ='<div class="md-card">
                        <div class="md-card-head-text">
                                Системная информация
                        </div>
                        <div class="md-card-content">';
        $phpver = phpversion();
        $osver = php_uname('s');
        $gdver = $this->php_gd();
        $dbver =$this-> db_version();
        $phpver = ($phpver >= "4.3.0") ? "<font color=\"green\">$phpver</font>" : "<font color=\"red\">$phpver</font>";
        $gdver = ($gdver >= "2.0") ? "<font color=\"green\">$gdver</font>" : "<font color=\"red\">$gdver</font>";
        $dbverv = ($dbver >= "4.0.0") ? "<font color=\"green\">".$this->cutstr($dbver, 8)."</font>" : "<font color=\"red\">".$this->cutstr($dbver, 8)."</font>";
        $globals = (ini_get('register_globals') == 1) ? "<font color=\"red\">On</font>" : "<font color=\"green\">Off</font>";
        $safe_mode = (ini_get('safe_mode') == 1) ? "<font color=\"green\">On</font>" : "<font color=\"red\">Off</font>";
        $magic_quotes = (ini_get('magic_quotes_gpc') == 1) ? "<font color=\"green\">On</font>" : "<font color=\"red\">Off</font>";
        $p_max = "".$this->files_size(str_replace("M", "", ini_get('post_max_size')) * 1024 * 1024)."";
        $u_max = "".$this->files_size(str_replace("M", "", ini_get('upload_max_filesize')) * 1024 * 1024)."";
        $m_max = "".$this->files_size(str_replace("M", "", ini_get('memory_limit')) * 1024 * 1024)."";
        $mod_rewrite = (function_exists('apache_get_modules')) ? ((array_search("mod_rewrite", apache_get_modules())) ? "<font color=\"green\">On</font>" : "<font color=\"red\">Off</font>") : "<font color=\"red\">Off</font>";
        $str .= "<table class=\"uk-table uk-table-striped uk-table-hover\" style=\"font-size: 16px;\">"
            ."<thead><tr>
                       <th>".\Uni::t('app', 'Name')."</th>
                        <th>".\Uni::t('app', 'Value')."</th>
                        </tr>
              </thead>"
            //."<tbody><tr><td>UMS:</td></td><td title=\"".$this->conf['version']."\"><font color=\"blue\">".$this->conf['version']."</font></td></tr>"
            ."<tr><td>OS:</td><td title=\"".$osver."\"><font color=\"blue\">".$osver."</font></td></tr>"
            ."<tr><td>PHP:</td><td>$phpver</td></tr>"
            ."<tr><td>PHP GD:</td><td>$gdver</td></tr>"
            ."<tr><td>MySQL:</td><td title=\"".$dbver."\">".$dbverv."</td></tr>"
            ."<tr><td>Post size:</td><td><font color=\"blue\">".$p_max."</font></td></tr>"
            ."<tr><td>Upload file size:</td><td><font color=\"blue\">".$u_max."</font></td></tr>"
            ."<tr><td>Memory limit:</td><td><font color=\"blue\">".$m_max."</font></td></tr>"
            ."<tr><td>Execution time:</td><td><font color=\"blue\">".ini_get('max_execution_time')." msec</font></td></tr>"
            ."<tr><td>Mod Rewrite:</td><td>".$mod_rewrite."</td></tr>"
            ."<tr><td>Register globals:</td><td>".$globals."</td></tr>"
            ."<tr><td>Safe mode:</td><td>".$safe_mode."</td></tr>"
            ."<tr><td>Magic quotes gpc:</td><td>".$magic_quotes."</td></tr></tbody>"
            ."</table>";
        $str .='</div></div>';
        return $str;
    }
    # Size filter
    public  function files_size($size) {
        $name = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
        $mysize = $size ? "".round($size / pow(1024, ($i = floor(log($size, 1024)))), 2)." ".$name[$i]."" : "".$size." Bytes";
        return $mysize;
    }

    /**
     * @return int
     */
    public   function php_gd() {
        ob_start();
        phpinfo(8);
        $module_info = ob_get_contents();
        ob_end_clean();
        if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info, $matches)) {
            $gdversion = $matches[1];
        } else {
            $gdversion = 0;
        }
        return $gdversion;
    }

    public function db_version() {
//        global $db;
//        list($dbversion) = $this->db->sql_fetchrow($db->sql_query("SELECT VERSION()"));
        return "5.5.2"; //$dbversion;
    }
    public function cutstr($linkstrip, $strip) {
        $linkstrip = stripslashes($linkstrip);
        if (strlen($linkstrip) > $strip) $linkstrip = mb_substr($linkstrip, 0, $strip, "utf-8")."...";
        return $linkstrip;
    }
} 