<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\generator;

use Uni;
use uni\web\ForbiddenHttpException;

/**
 * This is the main module class for the Gii module.
 *
 * To use Gii, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     ......
 *     'modules' => [
 *         'generator' => ['class' => 'uni\generator\Module'],
 *     ],
 * ]
 * ~~~
 *
 * Because Gii generates new code files on the server, you should only use it on your own
 * development machine. To prevent other people from using this module, by default, Gii
 * can only be accessed by localhost. You may configure its [[allowedIPs]] property if
 * you want to make it accessible on other machines.
 *
 * With the above configuration, you will be able to access GiiModule in your browser using
 * the URL `http://localhost/path/to/index.php?r=generator`
 *
 * If your application enables [[\uni\web\UrlManager::enablePrettyUrl|pretty URLs]] and you have defined
 * custom URL rules or enabled [[\uni\web\UrlManager::enableStrictParsing], you may need to add
 * the following URL rules at the beginning of your URL rule set in your application configuration
 * in order to access Gii:
 *
 * ~~~
 * 'rules' => [
 *     'generator' => 'generator',
 *     'generator/<controller>' => 'generator/<controller>',
 *     'generator/<controller>/<action>' => 'generator/<controller>/<action>',
 *     ...
 * ],
 * ~~~
 *
 * You can then access Gii via URL: `http://localhost/path/to/index.php/generator`
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class Module extends \uni\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'uni\generator\controllers';
    /**
     * @var array the list of IPs that are allowed to access this module.
     * Each array element represents a single IP filter which can be either an IP address
     * or an address with wildcard (e.g. 192.168.0.*) to represent a network segment.
     * The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed
     * by localhost.
     */
    public $allowedIPs = ['127.0.0.1', '::1'];
    /**
     * @var array|Generator[] a list of generator configurations or instances. The array keys
     * are the generator IDs (e.g. "crud"), and the array elements are the corresponding generator
     * configurations or the instances.
     *
     * After the module is initialized, this property will become an array of generator instances
     * which are created based on the configurations previously taken by this property.
     *
     * Newly assigned generators will be merged with the [[coreGenerators()|core ones]], and the former
     * takes precedence in case when they have the same generator ID.
     */
    public $generators = [];
    /**
     * @var integer the permission to be set for newly generated code files.
     * This value will be used by PHP chmod function.
     * Defaults to 0666, meaning the file is read-writable by all users.
     */
    public $newFileMode = 0666;
    /**
     * @var integer the permission to be set for newly generated directories.
     * This value will be used by PHP chmod function.
     * Defaults to 0777, meaning the directory can be read, written and executed by all users.
     */
    public $newDirMode = 0777;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        foreach (array_merge($this->coreGenerators(), $this->generators) as $id => $config) {
            $this->generators[$id] = Uni::createObject($config);
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($this->checkAccess()) {
            return parent::beforeAction($action);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
    }

    /**
     * @return boolean whether the module can be accessed by the current user
     */
    protected function checkAccess()
    {
        $ip = Uni::$app->getRequest()->getUserIP();
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
        Uni::warning('Access to Gii is denied due to IP address restriction. The requested IP is ' . $ip, __METHOD__);

        return false;
    }

    /**
     * Returns the list of the core code generator configurations.
     * @return array the list of the core code generator configurations.
     */
    protected function coreGenerators()
    {
        return [
            'model' => ['class' => 'uni\generator\generators\model\Generator'],
            'crud' => ['class' => 'uni\generator\generators\crud\Generator'],
            'controller' => ['class' => 'uni\generator\generators\controller\Generator'],
            'form' => ['class' => 'uni\generator\generators\form\Generator'],
            'module' => ['class' => 'uni\generator\generators\module\Generator'],
            'extension' => ['class' => 'uni\generator\generators\extension\Generator'],
        ];
    }
}
