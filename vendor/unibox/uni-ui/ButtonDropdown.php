<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\ui;

use uni\helpers\ArrayHelper;

/**
 * ButtonDropdown renders a group or split button dropdown bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * echo ButtonDropdown::widget([
 *     'label' => 'Action',
 *     'dropdown' => [
 *         'items' => [
 *             ['label' => 'DropdownA', 'url' => '/'],
 *             ['label' => 'DropdownB', 'url' => '#'],
 *         ],
 *     ],
 * ]);
 * ```
 * @see http://getbootstrap.com/javascript/#buttons
 * @see http://getbootstrap.com/components/#btn-dropdowns
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since alfa version
 */
class ButtonDropdown extends Widget
{
    /**
     * @var string the button label
     */
    public $label = 'Button';
    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see \uni\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since alfa version.1
     */
    public $containerOptions = [];
    /**
     * @var array the HTML attributes of the button.
     * @see \uni\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array the configuration array for [[Dropdown]].
     */
    public $dropdown = [];
    /**
     * @var boolean whether to display a group of split-styled button group.
     */
    public $split = false;
    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'button';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;


    /**
     * Renders the widget.
     */
    public function run()
    {
        // @todo use [[options]] instead of [[containerOptions]] and introduce [[buttonOptions]] before 2.1 release
        Html::addCssClass($this->containerOptions, ['widget' => 'btn-group']);
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        $this->registerPlugin('button');
        return implode("\n", [
            Html::beginTag($tag, $options),
            $this->renderButton(),
            $this->renderDropdown(),
            Html::endTag($tag)
        ]);
    }

    /**
     * Generates the button dropdown.
     * @return string the rendering result.
     */
    protected function renderButton()
    {
        Html::addCssClass($this->options, ['widget' => 'btn']);
        $label = $this->label;
        if ($this->encodeLabel) {
            $label = Html::encode($label);
        }
        if ($this->split) {
            $options = $this->options;
            $this->options['data-toggle'] = 'dropdown';
            Html::addCssClass($this->options, ['toggle' => 'dropdown-toggle']);
            unset($this->options['id']);
            $splitButton = Button::widget([
                'label' => '<span class="caret"></span>',
                'encodeLabel' => false,
                'options' => $this->options,
                'view' => $this->getView(),
            ]);
        } else {
            $label .= ' <span class="caret"></span>';
            $options = $this->options;
            if (!isset($options['href']) && $this->tagName === 'a') {
                $options['href'] = '#';
            }
            Html::addCssClass($options, ['toggle' => 'dropdown-toggle']);
            $options['data-toggle'] = 'dropdown';
            $splitButton = '';
        }

        return Button::widget([
            'tagName' => $this->tagName,
            'label' => $label,
            'options' => $options,
            'encodeLabel' => false,
            'view' => $this->getView(),
        ]) . "\n" . $splitButton;
    }

    /**
     * Generates the dropdown menu.
     * @return string the rendering result.
     */
    protected function renderDropdown()
    {
        $config = $this->dropdown;
        $config['clientOptions'] = false;
        $config['view'] = $this->getView();

        return Dropdown::widget($config);
    }
}
