<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\panels;

use Uni;
use uni\debug\Panel;

/**
 * Debugger panel that collects and displays application configuration and environment.
 *
 * @property array $extensions This property is read-only.
 * @property array $phpInfo This property is read-only.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ConfigPanel extends Panel
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Configuration';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Uni::$app->view->render('panels/config/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return Uni::$app->view->render('panels/config/detail', ['panel' => $this]);
    }

    /**
     * Returns data about extensions
     *
     * @return array
     */
    public function getExtensions()
    {
        $data = [];
        foreach ($this->data['extensions'] as $extension) {
            $data[$extension['name']] = $extension['version'];
        }
        ksort($data);

        return $data;
    }

    /**
     * Returns the BODY contents of the phpinfo() output
     *
     * @return array
     */
    public function getPhpInfo()
    {
        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
        $phpinfo = str_replace('<table', '<div class="table-responsive"><table class="table table-condensed table-bordered table-striped table-hover config-php-info-table" ', $phpinfo);
        $phpinfo = str_replace('</table>', '</table></div>', $phpinfo);
        return $phpinfo;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        return [
            'phpVersion' => PHP_VERSION,
            'uniVersion' => Uni::getVersion(),
            'application' => [
                'uni' => Uni::getVersion(),
                'name' => Uni::$app->name,
                'env' => UNI_ENV,
                'debug' => UNI_DEBUG,
            ],
            'php' => [
                'version' => PHP_VERSION,
                'xdebug' => extension_loaded('xdebug'),
                'apc' => extension_loaded('apc'),
                'memcache' => extension_loaded('memcache'),
            ],
            'extensions' => Uni::$app->extensions,
        ];
    }
}
