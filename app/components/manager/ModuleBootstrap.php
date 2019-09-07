<?php
/**
 * Created by PhpStorm.
 * User: Rashidov
 * Date: 23.05.2015
 * Time: 20:29
 */

namespace app\components\manager;

use uni\base\BootstrapInterface;
define("FILE_PATH_ROOT",__DIR__);
/**
 * Class ModuleBootstrap
 *
 * @package app\extensions
 */
class ModuleBootstrap implements BootstrapInterface
{
    /**
     * @param \uni\base\Application $oApplication
     */
    public function bootstrap($oApplication)
    {
        $aModuleList = $oApplication->getModules();

        foreach ($aModuleList as $sKey => $aModule) {
            if (is_array($aModule) && strpos($aModule['class'], 'app\modules') === 0) {
                $sFilePathConfig = FILE_PATH_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $sKey . DIRECTORY_SEPARATOR . 'config' . DS . '_routes.php';

                if (file_exists($sFilePathConfig)) {
                    $oApplication->getUrlManager()->addRules(require($sFilePathConfig));
                }
            }
        }
    }
}