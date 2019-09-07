<?php
namespace app\components\widgets;

use app\assets\VideoJsAsset;
use uni\helpers\Html;
use uni\helpers\Json;
use uni\base\InvalidConfigException;

class VideoJs extends \uni\base\Widget
{
    /**
     * @var array
     */
    public $options = [];
    /**
     * @var array
     */
    public $jsOptions = [];
    /**
     * @var array
     */
    public $tags = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initOptions();
        $this->registerAssets();
    }

    /**
     * Initializes the widget options
     */
    protected function initOptions()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = 'videojs-' . $this->getId();
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $obj = VideoJsAsset::register($view);

        echo "\n" . Html::beginTag('video', $this->options);
        if (!empty($this->tags) && is_array($this->tags)) {
            foreach ($this->tags as $tagName => $tags) {
                if (is_array($this->tags[$tagName])) {
                    foreach ($tags as $tagOptions) {
                        $tagContent = '';
                        if (isset($tagOptions['content'])) {
                            $tagContent = $tagOptions['content'];
                            unset($tagOptions['content']);
                        }
                        echo "\n" . Html::tag($tagName, $tagContent, $tagOptions);
                    }
                } else {
                    throw new InvalidConfigException("Invalid config for 'tags' property.");
                }
            }
        }
        echo "\n" .Html::endTag('video');

        if (!empty($this->jsOptions)) {
            $js = 'videojs("#' . $this->options['id'] . '").ready(' . Json::encode($this->jsOptions). ');';
            $view->registerJs($js);
        }
    }
}
