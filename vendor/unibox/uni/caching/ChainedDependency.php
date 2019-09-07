<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\caching;

/**
 * ChainedDependency represents a dependency which is composed of a list of other dependencies.
 *
 * When [[dependOnAll]] is true, if any of the dependencies has changed, this dependency is
 * considered changed; When [[dependOnAll]] is false, if one of the dependencies has NOT changed,
 * this dependency is considered NOT changed.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class ChainedDependency extends Dependency
{
    /**
     * @var Dependency[] list of dependencies that this dependency is composed of.
     * Each array element must be a dependency object.
     */
    public $dependencies = [];
    /**
     * @var boolean whether this dependency is depending on every dependency in [[dependencies]].
     * Defaults to true, meaning if any of the dependencies has changed, this dependency is considered changed.
     * When it is set false, it means if one of the dependencies has NOT changed, this dependency
     * is considered NOT changed.
     */
    public $dependOnAll = true;


    /**
     * Evaluates the dependency by generating and saving the data related with dependency.
     * @param Cache $cache the cache component that is currently evaluating this dependency
     */
    public function evaluateDependency($cache)
    {
        foreach ($this->dependencies as $dependency) {
            $dependency->evaluateDependency($cache);
        }
    }

    /**
     * Generates the data needed to determine if dependency has been changed.
     * This method does nothing in this class.
     * @param Cache $cache the cache component that is currently evaluating this dependency
     * @return mixed the data needed to determine if dependency has been changed.
     */
    protected function generateDependencyData($cache)
    {
        return null;
    }

    /**
     * Performs the actual dependency checking.
     * This method returns true if any of the dependency objects
     * reports a dependency change.
     * @param Cache $cache the cache component that is currently evaluating this dependency
     * @return boolean whether the dependency is changed or not.
     */
    public function getHasChanged($cache)
    {
        foreach ($this->dependencies as $dependency) {
            if ($this->dependOnAll && $dependency->getHasChanged($cache)) {
                return true;
            } elseif (!$this->dependOnAll && !$dependency->getHasChanged($cache)) {
                return false;
            }
        }

        return !$this->dependOnAll;
    }
}
