<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug;

use Uni;
use uni\base\Application;
use uni\base\BootstrapInterface;
use uni\helpers\Html;
use uni\helpers\Url;
use uni\web\View;
use uni\web\ForbiddenHttpException;

/**
 * The Uni Debug Module provides the debug toolbar and debugger
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class Module extends \uni\base\Module implements BootstrapInterface
{
    /**
     * @var array the list of IPs that are allowed to access this module.
     * Each array element represents a single IP filter which can be either an IP address
     * or an address with wildcard (e.g. 192.168.0.*) to represent a network segment.
     * The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed
     * by localhost.
     */
    public $allowedIPs = ['127.0.0.1', '::1'];
    /**
     * @var array the list of hosts that are allowed to access this module.
     * Each array element is a hostname that will be resolved to an IP address that is compared
     * with the IP address of the user. A use case is to use a dynamic DNS (DDNS) to allow access.
     * The default value is `[]`.
     */
    public $allowedHosts = [];
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'uni\debug\controllers';
    /**
     * @var LogTarget
     */
    public $logTarget;
    /**
     * @var array list of debug panels. The array keys are the panel IDs, and values are the corresponding
     * panel class names or configuration arrays. This will be merged with [[corePanels()]].
     * You may reconfigure a core panel via this property by using the same panel ID.
     * You may also disable a core panel by setting it to be false in this property.
     */
    public $panels = [];
    /**
     * @var string the directory storing the debugger data files. This can be specified using a path alias.
     */
    public $dataPath = '@runtime/debug';
    /**
     * @var integer the permission to be set for newly created debugger data files.
     * This value will be used by PHP [[chmod()]] function. No umask will be applied.
     * If not set, the permission will be determined by the current environment.
     * @since alfa version.6
     */
    public $fileMode;
    /**
     * @var integer the permission to be set for newly created directories.
     * This value will be used by PHP [[chmod()]] function. No umask will be applied.
     * Defaults to 0775, meaning the directory is read-writable by owner and group,
     * but read-only for other users.
     * @since alfa version.6
     */
    public $dirMode = 0775;
    /**
     * @var integer the maximum number of debug data files to keep. If there are more files generated,
     * the oldest ones will be removed.
     */
    public $historySize = 50;
    /**
     * @var boolean whether to enable message logging for the requests about debug module actions.
     * You normally do not want to keep these logs because they may distract you from the logs about your applications.
     * You may want to enable the debug logs if you want to investigate how the debug module itself works.
     */
    public $enableDebugLogs = false;


    /**
     * Returns Uni logo ready to use in `<img src="`
     *
     * @return string base64 representation of the image
     */
    public static function getUniLogo()
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAADJUlEQVRYCe1XS2sUQRCu3dnEZWFDgokGBUUPBh+skpkc9KKIoKCCr+DNm6s3QfA/eBAET+sSvXnzICIaXwQ8BZ2NRg2amwQ85IGRLNEkbmb8apwKPTM7r2BuGRiqu/qrqq+/6p5NiNaf1ShQNm3iF49+17b5XU0ajsmlCiybf8JimMTyQv3hh2tt/WlyZhOBy+YDd8eRhLV88QIT0Qod+UR5w3azElw2uSDvOtVz4PaP3xxQu5LJxAWG78jtcVyCqHU5G1FEggT+Q2E/KYeIbc3Urmpd/jW/RAX0et4PCsyrxnH4Xog/V+wq7b81NSrzKAs1WrDeEIznEILpPFUNje4d6hGAx1b7zmOdE6wU102yG/XpzyxzY25qxINvPmlX3YEWgMQyA5y+XXr5jvIdBlX7LhLZg3DPqcEyBol/McZmVjSnV6xFymQ8mxOs3wYICEA5QBp8lvijLKuB9UbNyHJMO3LMRuF5LZYlK7Lr+usjcYmU9RwTadlIS6zi6I3uvcpaYBhLgCOKPUeHWJHCNr01kCHEUXpO8875mJv8ykTq40N3mkE9t0BkbwZUfc75cB2u7Opy03HNIK7FG27D+1NAHgJw5kHC+YoJIMJaIMK9zoNEohiQ2AD8kprT0wJOxLvDu1UFhYwldoF3h3d7CI6wdpIxepkWgelUcYFb4Epq1QznO74PinxSAyLGE1yk4xid2HmTnjEO87MwgygcqlCAgFsgy0RmHtFuVkSvNHCvtUQHcPYVDaIwt6Ybhb+7+UKNyNgU0HmGvjCR8UquCCL8BUz6WEmKc7IwBTyFegac3kFSpy2daMu0B6BMUDjVX0eJCEh+9XxohfaS+NmmLSyx/mu4BUVi+8bBCxN0eewcDaQpXKvSYYS+keJs/QRkrQQisT+v7tWKlRyF+TY8xhv4TQlrwUdOboyQbQdChGO8fX+f+q0GPQXyVxg6jICDN3sdhVqhBn9AEj/8Q2xWaAcCvsUFRRJwg5dYDYw3gchkXELIfRCY4TicrCchINgph0iW9uhvaUycYlH4NMZPZL7mtneY6m6RU7CJ/w9Yc2LrBdIq8BdOwwDZlfzEhAAAAABJRU5ErkJggg==';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->dataPath = Uni::getAlias($this->dataPath);
        $this->initPanels();
    }

    /**
     * Initializes panels.
     */
    protected function initPanels()
    {
        // merge custom panels and core panels so that they are ordered mainly by custom panels
        if (empty($this->panels)) {
            $this->panels = $this->corePanels();
        } else {
            $corePanels = $this->corePanels();
            foreach ($corePanels as $id => $config) {
                if (isset($this->panels[$id])) {
                    unset($corePanels[$id]);
                }
            }
            $this->panels = array_filter(array_merge($corePanels, $this->panels));
        }

        foreach ($this->panels as $id => $config) {
            if (is_string($config)) {
                $config = ['class' => $config];
            }
            $config['module'] = $this;
            $config['id'] = $id;
            $this->panels[$id] = Uni::createObject($config);
        }
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $this->logTarget = Uni::$app->getLog()->targets['debug'] = new LogTarget($this);
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            $app->getView()->on(View::EVENT_END_BODY, [$this, 'renderToolbar']);
        });

        $app->getUrlManager()->addRules([
            [
                'class' => 'uni\web\UrlRule',
                'route' => $this->id,
                'pattern' => $this->id,
            ],
            [
                'class' => 'uni\web\UrlRule',
                'route' => $this->id . '/<controller>/<action>',
                'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>',
            ]
        ], false);
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!$this->enableDebugLogs) {
            foreach (Uni::$app->getLog()->targets as $target) {
                $target->enabled = false;
            }
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        // do not display debug toolbar when in debug view mode
        Uni::$app->getView()->off(View::EVENT_END_BODY, [$this, 'renderToolbar']);

        if ($this->checkAccess()) {
            $this->resetGlobalSettings();
            return true;
        } elseif ($action->id === 'toolbar') {
            // Accessing toolbar remotely is normal. Do not throw exception.
            return false;
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
    }

    /**
     * Resets potentially incompatible global settings done in app config.
     */
    protected function resetGlobalSettings()
    {
        Uni::$app->assetManager->bundles = [];
    }

    /**
     * Renders mini-toolbar at the end of page body.
     *
     * @param \uni\base\Event $event
     */
    public function renderToolbar($event)
    {
        if (!$this->checkAccess() || Uni::$app->getRequest()->getIsAjax()) {
            return;
        }
        $url = Url::toRoute(['/' . $this->id . '/default/toolbar',
            'tag' => $this->logTarget->tag,
        ]);
        echo '<div id="uni-debug-toolbar" data-url="' . Html::encode($url) . '" style="display:none" class="uni-debug-toolbar-bottom"></div>';
        /* @var $view View */
        $view = $event->sender;

        // echo is used in order to support cases where asset manager is not available
        echo '<style>' . $view->renderPhpFile(__DIR__ . '/assets/toolbar.css') . '</style>';
        echo '<script>' . $view->renderPhpFile(__DIR__ . '/assets/toolbar.js') . '</script>';
    }

    /**
     * Checks if current user is allowed to access the module
     * @return boolean if access is granted
     */
    protected function checkAccess()
    {
        $ip = Uni::$app->getRequest()->getUserIP();
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
        foreach ($this->allowedHosts as $hostname) {
            $filter = gethostbyname($hostname);
            if ($filter === $ip) {
                return true;
            }
        }
        Uni::warning('Access to debugger is denied due to IP address restriction. The requesting IP address is ' . $ip, __METHOD__);
        return false;
    }

    /**
     * @return array default set of panels
     */
    protected function corePanels()
    {
        return [
            'config' => ['class' => 'uni\debug\panels\ConfigPanel'],
            'request' => ['class' => 'uni\debug\panels\RequestPanel'],
            'log' => ['class' => 'uni\debug\panels\LogPanel'],
            'profiling' => ['class' => 'uni\debug\panels\ProfilingPanel'],
            'db' => ['class' => 'uni\debug\panels\DbPanel'],
            'assets' => ['class' => 'uni\debug\panels\AssetPanel'],
            'mail' => ['class' => 'uni\debug\panels\MailPanel'],
        ];
    }
}
