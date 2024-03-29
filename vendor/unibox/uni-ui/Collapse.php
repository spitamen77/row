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
 * Collapse renders an accordion bootstrap javascript component.
 *
 * For example:
 *
 * ```php
 * echo Collapse::widget([
 *     'items' => [
 *         // equivalent to the above
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             // open its content by default
 *             'contentOptions' => ['class' => 'in']
 *         ],
 *         // another group item
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => 'Anim pariatur cliche...',
 *             'contentOptions' => [...],
 *             'options' => [...],
 *         ],
 *         // if you want to swap out .panel-body with .list-group, you may use the following
 *         [
 *             'label' => 'Collapsible Group Item #1',
 *             'content' => [
 *                 'Anim pariatur cliche...',
 *                 'Anim pariatur cliche...'
 *             ],
 *             'contentOptions' => [...],
 *             'options' => [...],
 *             'footer' => 'Footer' // the footer label in list-group
 *         ],
 *     ]
 * ]);
 * ```
 *
 * @see http://getbootstrap.com/javascript/#collapse
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since alfa version
 */
class Collapse extends Widget
{
    /**
     * @var array list of groups in the collapse widget. Each array element represents a single
     * group with the following structure:
     *
     * - label: string, required, the group header label.
     * - encode: boolean, optional, whether this label should be HTML-encoded. This param will override
     *   global `$this->encodeLabels` param.
     * - content: array|string|object, required, the content (HTML) of the group
     * - options: array, optional, the HTML attributes of the group
     * - contentOptions: optional, the HTML attributes of the group's content
     */
    public $items = [];
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, ['widget' => 'panel-group']);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('collapse');
        return implode("\n", [
            Html::beginTag('div', $this->options),
            $this->renderItems(),
            Html::endTag('div')
        ]) . "\n";
    }

    /**
     * Renders collapsible items as specified on [[items]].
     * @throws InvalidConfigException if label isn't specified
     * @return string the rendering result
     */
    public function renderItems()
    {
        $items = [];
        $index = 0;
        foreach ($this->items as $item) {
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $header = $item['label'];
            $options = ArrayHelper::getValue($item, 'options', []);
            Html::addCssClass($options, ['panel' => 'panel', 'widget' => 'panel-default']);
            $items[] = Html::tag('div', $this->renderItem($header, $item, ++$index), $options);
        }

        return implode("\n", $items);
    }

    /**
     * Renders a single collapsible item group
     * @param string $header a label of the item group [[items]]
     * @param array $item a single item from [[items]]
     * @param integer $index the item index as each item group content must have an id
     * @return string the rendering result
     * @throws InvalidConfigException
     */
    public function renderItem($header, $item, $index)
    {
        if (array_key_exists('content', $item)) {
            $id = $this->options['id'] . '-collapse' . $index;
            $options = ArrayHelper::getValue($item, 'contentOptions', []);
            $options['id'] = $id;
            Html::addCssClass($options, ['widget' => 'panel-collapse', 'collapse' => 'collapse']);

            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            if ($encodeLabel) {
                $header = Html::encode($header);
            }

            $headerToggle = Html::a($header, '#' . $id, [
                    'class' => 'collapse-toggle',
                    'data-toggle' => 'collapse',
                    'data-parent' => '#' . $this->options['id']
                ]) . "\n";

            $header = Html::tag('h4', $headerToggle, ['class' => 'panel-title']);

            if (is_string($item['content']) || is_object($item['content'])) {
                $content = Html::tag('div', $item['content'], ['class' => 'panel-body']) . "\n";
            } elseif (is_array($item['content'])) {
                $content = Html::ul($item['content'], [
                    'class' => 'list-group',
                    'itemOptions' => [
                        'class' => 'list-group-item'
                    ],
                    'encode' => false,
                ]) . "\n";
                if (isset($item['footer'])) {
                    $content .= Html::tag('div', $item['footer'], ['class' => 'panel-footer']) . "\n";
                }
            } else {
                throw new InvalidConfigException('The "content" option should be a string, array or object.');
            }
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }
        $group = [];

        $group[] = Html::tag('div', $header, ['class' => 'panel-heading']);
        $group[] = Html::tag('div', $content, $options);

        return implode("\n", $group);
    }
}
