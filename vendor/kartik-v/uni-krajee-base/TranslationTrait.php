<?php

/**
 * @package   yii2-krajee-base
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 * @version   1.8.9
 */

namespace kartik\base;

use Uni;
use uni\helpers\ArrayHelper;

/**
 * TranslationTrait manages methods for all translations used in Krajee extensions
 *
 * @property array $i18n
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.8.9
 */
trait TranslationTrait
{
    /**
     * Uni i18n messages configuration for generating translations
     *
     * @param string $dir the directory path where translation files will exist
     * @param string $cat the message category
     *
     * @return void
     */
    public function initI18N($dir = '', $cat = '')
    {
        if (empty($cat) && empty($this->_msgCat)) {
            return;
        }
        if (empty($cat)) {
            $cat = $this->_msgCat;
        }
        if (empty($dir)) {
            $reflector = new \ReflectionClass(get_class($this));
            $dir = dirname($reflector->getFileName());
        }
        Uni::setAlias("@{$cat}", $dir);
        $config = [
            'class' => 'uni\i18n\PhpMessageSource',
            'basePath' => "@{$cat}/messages",
            'forceTranslation' => true
        ];
        $globalConfig = ArrayHelper::getValue(Uni::$app->i18n->translations, "{$cat}*", []);
        if (!empty($globalConfig)) {
            $config = array_merge($config, is_array($globalConfig) ? $globalConfig : (array) $globalConfig);
        }
        if (!empty($this->i18n) && is_array($this->i18n)) {
            $config = array_merge($config, $this->i18n);
        }
        Uni::$app->i18n->translations["{$cat}*"] = $config;
    }
}
