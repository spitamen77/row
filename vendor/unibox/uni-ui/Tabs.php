<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\ui;

use uni\base\InvalidConfigException;
use uni\helpers\ArrayHelper;

/**
 * Tabs renders a Tab bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Tabs::widget([
 *     'items' => [
 *         [
 *             'label' => 'One',
 *             'content' => 'Anim pariatur cliche...',
 *             'active' => true
 *         ],
 *         [
 *             'label' => 'Two',
 *             'content' => 'Anim pariatur cliche...',
 *             'headerOptions' => [...],
 *             'options' => ['id' => 'myveryownID'],
 *         ],
 *         [
 *             'label' => 'Example',
 *             'url' => 'http://www.example.com',
 *         ],
 *         [
 *             'label' => 'Dropdown',
 *             'items' => [
 *                  [
 *                      'label' => 'DropdownA',
 *                      'content' => 'DropdownA, Anim pariatur cliche...',
 *                  ],
 *                  [
 *                      'label' => 'DropdownB',
 *                      'content' => 'DropdownB, Anim pariatur cliche...',
 *                  ],
 *             ],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see http://getbootstrap.com/javascript/#tabs
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since alfa version
 */
class Tabs extends Widget
{
    /**
     * @var array list of tabs in the tabs widget. Each array element represents a single
     * tab with the following structure:
     *
     * - label: string, required, the tab header label.
     * - encode: boolean, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - headerOptions: array, optional, the HTML attributes of the tab header.
     * - linkOptions: array, optional, the HTML attributes of the tab header link tags.
     * - content: string, optional, the content (HTML) of the tab pane.
     * - url: string, optional, an external URL. When this is specified, clicking on this tab will bring
     *   the browser to this URL. This option is available since version 2.0.4.
     * - options: array, optional, the HTML attributes of the tab pane container.
     * - active: boolean, optional, whether this item tab header and pane should be active. If no item is marked as
     *   'active' explicitly - the first one will be activated.
     * - visible: boolean, optional, whether the item tab header and pane should be visible or not. Defaults to true.
     * - items: array, optional, can be used instead of `content` to specify a dropdown items
     *   configuration array. Each item can hold three extra keys, besides the above ones:
     *     * active: boolean, optional, whether the item tab header and pane should be visible or not.
     *     * content: string, required if `items` is not set. The content (HTML) of the tab pane.
     *     * contentOptions: optional, array, the HTML attributes of the tab content container.
     */
    public $items = [];
    /**
     * @var array list of HTML attributes for the item container tags. This will be overwritten
     * by the "options" set in individual [[items]]. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the tag name of the item container tags.
     *
     * @see \uni\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $itemOptions = [];
    /**
     * @var array list of HTML attributes for the header container tags. This will be overwritten
     * by the "headerOptions" set in individual [[items]].
     * @see \uni\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $headerOptions = [];
    /**
     * @var array list of HTML attributes for the tab header link tags. This will be overwritten
     * by the "linkOptions" set in individual [[items]].
     * @see \uni\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;
    /**
     * @var string specifies the Bootstrap tab styling.
     */
    public $navType = 'nav-tabs';
    /**
     * @var boolean whether to render the `tab-content` container and its content. You may set this property
     * to be false so that you can manually render `tab-content` yourself in case your tab contents are complex.
     * @since alfa version.1
     */
    public $renderTabContent = true;


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, ['widget' => 'nav', $this->navType]);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('tab');
        return $this->renderItems();
    }

    /**
     * Renders tab items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $headers = [];
        $panes = [];

        if (!$this->hasActiveTab() && !empty($this->items)) {
            $this->items[0]['active'] = true;
        }

        foreach ($this->items as $n => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $headerOptions = array_merge($this->headerOptions, ArrayHelper::getValue($item, 'headerOptions', []));
            $linkOptions = array_merge($this->linkOptions, ArrayHelper::getValue($item, 'linkOptions', []));

            if (isset($item['items'])) {
                $label .= ' <b class="caret"></b>';
                Html::addCssClass($headerOptions, ['widget' => 'dropdown']);

                if ($this->renderDropdown($n, $item['items'], $panes)) {
                    Html::addCssClass($headerOptions, 'active');
                }

                Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
                if (!isset($linkOptions['data-toggle'])) {
                    $linkOptions['data-toggle'] = 'dropdown';
                }
                $header = Html::a($label, "#", $linkOptions) . "\n"
                    . Dropdown::widget(['items' => $item['items'], 'clientOptions' => false, 'view' => $this->getView()]);
            } else {
                $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
                $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-tab' . $n);

                Html::addCssClass($options, ['widget' => 'tab-pane']);
                if (ArrayHelper::remove($item, 'active')) {
                    Html::addCssClass($options, 'active');
                    Html::addCssClass($headerOptions, 'active');
                }

                if (isset($item['url'])) {
                    $header = Html::a($label, $item['url'], $linkOptions);
                } else {
                    if (!isset($linkOptions['data-toggle'])) {
                        $linkOptions['data-toggle'] = 'tab';
                    }
                    $header = Html::a($label, '#' . $options['id'], $linkOptions);
                }

                if ($this->renderTabContent) {
                    $panes[] = Html::tag('div', isset($item['content']) ? $item['content'] : '', $options);
                }
            }

            $headers[] = Html::tag('li', $header, $headerOptions);
        }

        return Html::tag('ul', implode("\n", $headers), $this->options)
        . ($this->renderTabContent ? "\n" . Html::tag('div', implode("\n", $panes), ['class' => 'tab-content']) : '');
    }

    /**
     * @return boolean if there's active tab defined
     */
    protected function hasActiveTab()
    {
        foreach ($this->items as $item) {
            if (isset($item['active']) && $item['active'] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalizes dropdown item options by removing tab specific keys `content` and `contentOptions`, and also
     * configure `panes` accordingly.
     * @param string $itemNumber number of the item
     * @param array $items the dropdown items configuration.
     * @param array $panes the panes reference array.
     * @return boolean whether any of the dropdown items is `active` or not.
     * @throws InvalidConfigException
     */
    protected function renderDropdown($itemNumber, &$items, &$panes)
    {
        $itemActive = false;

        foreach ($items as $n => &$item) {
            if (is_string($item)) {
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (!array_key_exists('content', $item)) {
                throw new InvalidConfigException("The 'content' option is required.");
            }

            $content = ArrayHelper::remove($item, 'content');
            $options = ArrayHelper::remove($item, 'contentOptions', []);
            Html::addCssClass($options, ['widget' => 'tab-pane']);
            if (ArrayHelper::remove($item, 'active')) {
                Html::addCssClass($options, 'active');
                Html::addCssClass($item['options'], 'active');
                $itemActive = true;
            }

            $options['id'] = ArrayHelper::getValue($options, 'id', $this->options['id'] . '-dd' . $itemNumber . '-tab' . $n);
            $item['url'] = '#' . $options['id'];
            if (!isset($item['linkOptions']['data-toggle'])) {
                $item['linkOptions']['data-toggle'] = 'tab';
            }
            $panes[] = Html::tag('div', $content, $options);

            unset($item);
        }

        return $itemActive;
    }
}
