<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\base;

/**
 * ActionFilter is the base class for action filters.
 *
 * An action filter will participate in the action execution workflow by responding to
 * the `beforeAction` and `afterAction` events triggered by modules and controllers.
 *
 * Check implementation of [[\uni\filters\AccessControl]], [[\uni\filters\PageCache]] and [[\uni\filters\HttpCache]] as examples on how to use it.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ActionFilter extends Behavior
{
    /**
     * @var array list of action IDs that this filter should apply to. If this property is not set,
     * then the filter applies to all actions, unless they are listed in [[except]].
     * If an action ID appears in both [[only]] and [[except]], this filter will NOT apply to it.
     *
     * Note that if the filter is attached to a module, the action IDs should also include child module IDs (if any)
     * and controller IDs.
     *
     * @see except
     */
    public $only;
    /**
     * @var array list of action IDs that this filter should not apply to.
     * @see only
     */
    public $except = [];

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        $this->owner = $owner;
        $owner->on(Controller::EVENT_BEFORE_ACTION, [$this, 'beforeFilter']);
    }

    /**
     * @inheritdoc
     */
    public function detach()
    {
        if ($this->owner) {
            $this->owner->off(Controller::EVENT_BEFORE_ACTION, [$this, 'beforeFilter']);
            $this->owner->off(Controller::EVENT_AFTER_ACTION, [$this, 'afterFilter']);
            $this->owner = null;
        }
    }

    /**
     * @param ActionEvent $event
     */
    public function beforeFilter($event)
    {
        if (!$this->isActive($event->action)) {
            return;
        }

        $event->isValid = $this->beforeAction($event->action);
        if ($event->isValid) {
            // call afterFilter only if beforeFilter succeeds
            // beforeFilter and afterFilter should be properly nested
            $this->owner->on(Controller::EVENT_AFTER_ACTION, [$this, 'afterFilter'], null, false);
        } else {
            $event->handled = true;
        }
    }

    /**
     * @param ActionEvent $event
     */
    public function afterFilter($event)
    {
        $event->result = $this->afterAction($event->action, $event->result);
        $this->owner->off(Controller::EVENT_AFTER_ACTION, [$this, 'afterFilter']);
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {
        return true;
    }

    /**
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param Action $action the action just executed.
     * @param mixed $result the action execution result
     * @return mixed the processed action result.
     */
    public function afterAction($action, $result)
    {
        return $result;
    }

    /**
     * Returns an $action ID, convert action uniqueId into an ID relative to the module
     * @param Action $action
     * @return string
     * @since alfa version.7
     */
    protected function getActionId($action) {
        if ($this->owner instanceof Module) {
            $mid = $this->owner->getUniqueId();
            $id = $action->getUniqueId();
            if ($mid !== '' && strpos($id, $mid) === 0) {
                $id = substr($id, strlen($mid) + 1);
            }
        } else {
            $id = $action->id;
        }

        return $id;
    }

    /**
     * Returns a value indicating whether the filter is active for the given action.
     * @param Action $action the action being filtered
     * @return boolean whether the filter is active for the given action.
     */
    protected function isActive($action)
    {
        $id = $this->getActionId($action);
        return !in_array($id, $this->except, true) && (empty($this->only) || in_array($id, $this->only, true));
    }
}
