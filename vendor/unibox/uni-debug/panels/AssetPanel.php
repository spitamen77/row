<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\panels;

use Uni;
use uni\helpers\Html;
use uni\debug\Panel;
use uni\web\AssetBundle;
use uni\web\AssetManager;

/**
 * Debugger panel that collects and displays asset bundles data.
 *
 * @author Artur Fursa <arturfursa@gmail.com>
 * @since alfa version
 */
class AssetPanel extends Panel
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Asset Bundles';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Uni::$app->view->render('panels/assets/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return Uni::$app->view->render('panels/assets/detail', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $bundles = Uni::$app->view->assetManager->bundles;
        if (empty($bundles)) { // bundles can be false
            return [];
        }
        $data = [];
        foreach ($bundles as $name => $bundle) {
            if ($bundle instanceof AssetBundle) {
                $bundleData = (array) $bundle;
                if (isset($bundleData['publishOptions']['beforeCopy']) && $bundleData['publishOptions']['beforeCopy'] instanceof \Closure) {
                    $bundleData['publishOptions']['beforeCopy'] = '\Closure';
                }
                if (isset($bundleData['publishOptions']['afterCopy']) && $bundleData['publishOptions']['afterCopy'] instanceof \Closure) {
                    $bundleData['publishOptions']['afterCopy'] = '\Closure';
                }
                $data[$name] = $bundleData;
            }
        }
        return $data;
    }

    /**
     * Additional formatting for view.
     *
     * @param AssetBundle[] $bundles Array of bundles to formatting.
     *
     * @return AssetManager
     */
    protected function format(array $bundles)
    {
        foreach ($bundles as $bundle) {

            $this->cssCount += count($bundle->css);
            $this->jsCount += count($bundle->js);

            array_walk($bundle->css, function(&$file, $key, $userdata) {
                $file = Html::a($file, $userdata->baseUrl . '/' . $file, ['target' => '_blank']);
            }, $bundle);

            array_walk($bundle->js, function(&$file, $key, $userdata) {
                $file = Html::a($file, $userdata->baseUrl . '/' . $file, ['target' => '_blank']);
            }, $bundle);

            array_walk($bundle->depends, function(&$depend) {
                $depend = Html::a($depend, '#' . $depend);
            });

            $this->formatOptions($bundle->publishOptions);
            $this->formatOptions($bundle->jsOptions);
            $this->formatOptions($bundle->cssOptions);
        }

        return $bundles;
    }

    /**
     * Format associative array of params to simple value.
     *
     * @param array $params
     *
     * @return array
     */
    protected function formatOptions(array &$params)
    {
        if (!is_array($params)) {
            return $params;
        }

        foreach ($params as $param => $value) {
            $params[$param] = Html::tag('strong', '\'' . $param . '\' => ') . (string) $value;
        }

        return $params;
    }
}
