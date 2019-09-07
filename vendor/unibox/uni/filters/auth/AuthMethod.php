<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\filters\auth;

use Uni;
use uni\base\Action;
use uni\base\ActionFilter;
use uni\web\UnauthorizedHttpException;
use uni\web\User;
use uni\web\Request;
use uni\web\Response;

/**
 * AuthMethod is a base class implementing the [[AuthInterface]] interface.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
abstract class AuthMethod extends ActionFilter implements AuthInterface
{
    /**
     * @var User the user object representing the user authentication status. If not set, the `user` application component will be used.
     */
    public $user;
    /**
     * @var Request the current request. If not set, the `request` application component will be used.
     */
    public $request;
    /**
     * @var Response the response to be sent. If not set, the `response` application component will be used.
     */
    public $response;
    /**
     * @var array list of action IDs that this filter will be applied to, but auth failure will not lead to error.
     * It may be used for actions, that are allowed for public, but return some additional data for authenticated users.
     * @see isOptional
     * @since alfa version.7
     */
    public $optional = [];


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $response = $this->response ? : Uni::$app->getResponse();

        try {
            $identity = $this->authenticate(
                $this->user ? : Uni::$app->getUser(),
                $this->request ? : Uni::$app->getRequest(),
                $response
            );
        } catch (UnauthorizedHttpException $e) {
            if ($this->isOptional($action)) {
                return true;
            }

            throw $e;
        }

        if ($identity !== null || $this->isOptional($action)) {
            return true;
        } else {
            $this->challenge($response);
            $this->handleFailure($response);
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function challenge($response)
    {
    }

    /**
     * @inheritdoc
     */
    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('You are requesting with an invalid credential.');
    }

    /**
     * Checks, whether the $action is optional
     *
     * @param Action $action
     * @return boolean
     * @see optional
     * @since alfa version.7
     */
    protected function isOptional($action) {
        $id = $this->getActionId($action);
        return in_array($id, $this->optional, true);
    }

    /**
     * {@inheritdoc}
     */
    protected function isActive($action)
    {
        return parent::isActive($action) || $this->isOptional($action);
    }
}
