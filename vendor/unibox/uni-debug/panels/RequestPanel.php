<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\debug\panels;

use Uni;
use uni\base\InlineAction;
use uni\debug\Panel;

/**
 * Debugger panel that collects and displays request data.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class RequestPanel extends Panel
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Request';
    }

    /**
     * @inheritdoc
     */
    public function getSummary()
    {
        return Uni::$app->view->render('panels/request/summary', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return Uni::$app->view->render('panels/request/detail', ['panel' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $headers = Uni::$app->getRequest()->getHeaders();
        $requestHeaders = [];
        foreach ($headers as $name => $value) {
            if (is_array($value) && count($value) == 1) {
                $requestHeaders[$name] = current($value);
            } else {
                $requestHeaders[$name] = $value;
            }
        }

        $responseHeaders = [];
        foreach (headers_list() as $header) {
            if (($pos = strpos($header, ':')) !== false) {
                $name = substr($header, 0, $pos);
                $value = trim(substr($header, $pos + 1));
                if (isset($responseHeaders[$name])) {
                    if (!is_array($responseHeaders[$name])) {
                        $responseHeaders[$name] = [$responseHeaders[$name], $value];
                    } else {
                        $responseHeaders[$name][] = $value;
                    }
                } else {
                    $responseHeaders[$name] = $value;
                }
            } else {
                $responseHeaders[] = $header;
            }
        }
        if (Uni::$app->requestedAction) {
            if (Uni::$app->requestedAction instanceof InlineAction) {
                $action = get_class(Uni::$app->requestedAction->controller) . '::' . Uni::$app->requestedAction->actionMethod . '()';
            } else {
                $action = get_class(Uni::$app->requestedAction) . '::run()';
            }
        } else {
            $action = null;
        }

        return [
            'flashes' => $this->getFlashes(),
            'statusCode' => Uni::$app->getResponse()->getStatusCode(),
            'requestHeaders' => $requestHeaders,
            'responseHeaders' => $responseHeaders,
            'route' => Uni::$app->requestedAction ? Uni::$app->requestedAction->getUniqueId() : Uni::$app->requestedRoute,
            'action' => $action,
            'actionParams' => Uni::$app->requestedParams,
            'requestBody' => Uni::$app->getRequest()->getRawBody() == '' ? [] : [
                'Content Type' => Uni::$app->getRequest()->getContentType(),
                'Raw' => Uni::$app->getRequest()->getRawBody(),
                'Decoded to Params' => Uni::$app->getRequest()->getBodyParams(),
            ],
            'SERVER' => empty($_SERVER) ? [] : $_SERVER,
            'GET' => empty($_GET) ? [] : $_GET,
            'POST' => empty($_POST) ? [] : $_POST,
            'COOKIE' => empty($_COOKIE) ? [] : $_COOKIE,
            'FILES' => empty($_FILES) ? [] : $_FILES,
            'SESSION' => empty($_SESSION) ? [] : $_SESSION,
        ];
    }

    /**
     * Getting flash messages without deleting them or touching deletion counters
     *
     * @return array flash messages (key => message).
     */
    protected function getFlashes()
    {
        /* @var $session \uni\web\Session */
        $session = Uni::$app->has('session', true) ? Uni::$app->get('session') : null;
        if ($session === null || !$session->getIsActive()) {
            return [];
        }

        $counters = $session->get($session->flashParam, []);
        $flashes = [];
        foreach (array_keys($counters) as $key) {
            if (array_key_exists($key, $_SESSION)) {
                $flashes[$key] = $_SESSION[$key];
            }
        }
        return $flashes;
    }
}
