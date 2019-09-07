<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni2-widgets
 * @version 3.4.1
 */

namespace kartik\widgets;
use uni\web\View;
/**
 * Base input widget class for uni2-widgets
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class InputWidget extends \uni\widgets\InputWidget
{
 const LOAD_PROGRESS = '<div class="kv-plugin-loading">&nbsp;</div>';
    /**
     * @var string the module identifier if this widget is part of a module. If not set, the module identifier will
     * be auto derived based on the \yii\base\Module::getInstance method. This can be useful, if you are setting
     * multiple module identifiers for the same module in your Yii configuration file. To specify children or grand
     * children modules you can specify the module identifiers relative to the parent module (e.g. `admin/content`).
     */
    public $moduleId;
    /**
     * @var string the language configuration (e.g. 'fr-FR', 'zh-CN'). The format for the language/locale is
     * ll-CC where ll is a two or three letter lowercase code for a language according to ISO-639 and
     * CC is the country code according to ISO-3166.
     * If this property not set, then the current application language will be used.
     */
    public $language;
    /**
     * @var boolean whether input is to be disabled
     */
    public $disabled = false;
    /**
     * @var boolean whether input is to be readonly
     */
    public $readonly = false;
    /**
     * @var string the javascript that will be used to destroy the jQuery plugin
     */
    public $pluginDestroyJs;
    /**
     * @var boolean show loading indicator while plugin loads
     */
    public $pluginLoading = true;
    /**
     * @var array the data (for list inputs)
     */
    public $data = [];
    /**
     * @var string the name of the jQuery plugin.
     */
    public $pluginName = '';
    /**
     * @var array the default HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $defaultOptions = [];
    /**
     * @var array widget plugin options.
     */
    public $defaultPluginOptions = [];
    /**
     * @var array widget plugin options.
     */
    public $pluginOptions = [];
    /**
     * @var array widget JQuery events. You must define events in `event-name => event-function` format. For example:
     *
     * ~~~
     * pluginEvents = [
     *     'change' => 'function() { log("change"); }',
     *     'open' => 'function() { log("open"); }',
     * ];
     * ~~~
     */
    public $pluginEvents = [];
    /**
     * @var string a pjax container identifier if applicable inside which the widget will be rendered. If this is set,
     * the widget will automatically reinitialize on pjax render completion.
     */
    public $pjaxContainerId;
    /**
     * @var boolean enable pop state fix for pjax container on press of browser back & forward buttons.
     */
    public $enablePopStateFix = true;
    /**
     * @var boolean whether the widget should automatically format the date from the PHP DateTime format to the
     * javascript/jquery plugin format. This is more applicable for widgets that manage date / time inputs.
     *
     * @see http://php.net/manual/en/function.date.php
     */
    public $convertFormat = false;
    
    /**
     * @var integer the position where the client JS hash variables for the input widget will be loaded. 
     * Defaults to `View::POS_HEAD`. This can be set to `View::POS_READY` for specific scenarios like when
     * rendering the widget via `renderAjax`.
     */
    public $hashVarLoadPosition = View::POS_HEAD;
    /**
     * @var array the the internalization configuration for this widget.
     *
     * @see [[\yii\i18n\I18N]] component for understanding the configuration details.
     */
    public $i18n = [];
    /**
     * @var string the HTML5 data variable name that will be used to store the Json encoded pluginOptions within the
     * element on which the jQuery plugin will be initialized.
     */
    protected $_dataVar;
    /**
     * @var string the generated hashed variable name that will store the JSON encoded pluginOptions in
     * [[View::POS_HEAD]].
     */
    protected $_hashVar;
    /**
     * @var string the JSON encoded plugin options.
     */
    protected $_encOptions = '';
    /**
     * @var string the indicator to be displayed while plugin is loading.
     */
    protected $_loadIndicator = '';
    /**
     * @var string the two or three letter lowercase code for the language according to ISO-639.
     */
    protected $_lang = '';
    /**
     * @var string the language js file.
     */
    protected $_langFile = '';
    /**
     * @var string translation message file category name for i18n.
     *
     * @see [[\yii\i18n\I18N]]
     */
    protected $_msgCat = '';

}